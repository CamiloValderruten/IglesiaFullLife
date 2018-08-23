<?php

namespace YOOtheme;

use YOOtheme\Http\Uri;
use YOOtheme\Util\File;

class ImageProvider implements \ArrayAccess
{
    use ContainerTrait;

    const IMAGE = '/<img\s+[^>]*src=[\"\'](.+?\.(?:gif|png|jpe?g)\?.+?)[\"\'][^>]*>/i';

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var \ArrayAccess
     */
    protected $container;

    /**
     * @var array
     */
    protected static $cache = [];

    /**
     * Constructor.
     *
     * @param \ArrayAccess $container
     * @param string       $path
     * @param string       $secret
     */
    public function __construct(\ArrayAccess $container, $path, $secret)
    {
        $this->path = File::normalizePath($path);
        $this->secret = $secret;
        $this->container = $container;
    }

    /**
     * Creates an image.
     *
     * @param  string $src
     * @param  bool   $resource
     * @param  bool   $params
     * @return Image|false
     */
    public function create($src, $resource = true, $params = true)
    {
        if (!$file = $this->getFile($src)) {
            return false;
        }

        $image = new Image($file, $this->path, $resource);

        if ($params) {
            $image->batch($this->getParams($src));
        }

        return $image;
    }

    /**
     * Replace images in HTML.
     *
     * @param  string $text
     * @return string
     */
    public function replace($text)
    {
        return strpos($text, '<img') !== false ? preg_replace_callback(static::IMAGE, [$this, 'replaceCallback'], $text) : $text;
    }

    /**
     * Replace image callback.
     *
     * @param  array $matches
     * @return string
     */
    public function replaceCallback($matches)
    {
        list($img, $src) = $matches;

        $source = html_entity_decode($src);

        if ($image = $this->create($source, false)) {

            $url = $this->getUrl($source);
            $width = $image->getWidth();
            $srcset = '';

            if ($sizes = $this->getSizes($source)) {
                $sizes[] = "{$url} {$width}w";
                $srcset = '" srcset="'.htmlspecialchars(join(', ', $sizes))."\" sizes=\"(min-width: {$width}px) {$width}px, 100vw";
            }

            return str_replace($src, htmlspecialchars($url).$srcset, $img);
        }

        return $img;
    }

    /**
     * Gets the image file.
     *
     * @param  string $src
     * @return string|false
     */
    public function getFile($src)
    {
        $file = urldecode(parse_url($src, PHP_URL_PATH));

        if (File::isRelative($file)) {
            return File::find($file);
        }

        return file_exists($file) ? $file : false;
    }

    /**
     * Gets the image parameters.
     *
     * @param  string $src
     * @return array
     */
    public function getParams($src)
    {
        $query = parse_url($src, PHP_URL_QUERY);

        parse_str($query, $params);

        return array_map(function ($value) {
            return explode(',', trim($value));
        }, $params);
    }

    /**
     * Gets the image hash.
     *
     * @param  string $src
     * @return string
     */
    public function getHash($src)
    {
        return hash_hmac('md5', urldecode($src), $this->secret);
    }

    /**
     * Gets the image URL.
     *
     * @param  string $src
     * @return string|null
     */
    public function getUrl($src)
    {
        if (!$image = $this->create($src, false)) {
            return $src;
        }

        if (file_exists($file = $image->getFile())) {
            $url = $this['url']->to($file);
        } else {
            $url = $this['url']->route('theme/image', ['src' => base64_encode($src), 'hash' => $this->getHash($src)]);
        }

        return $url;
    }

    /**
     * Gets the image sizes.
     *
     * @param  string $src
     * @return array
     */
    public function getSizes($src)
    {
        $sizes = [];
        $image = $this->create($src, false, false);
        $params = $this->getParams($src);

        if (isset($params['sizes'])) {
            foreach ($params['sizes'] as $value) {

                $url = Uri::fromString($src);
                $img = $this->create($url, false)->resize($value);
                $sized = [$img->getWidth(), $img->getHeight()];
                $params = $this->getParams($src);

                unset($params['sizes']);

                if ($img->getWidth() > $image->getWidth()) {
                    continue;
                }

                if (isset($params['thumbnail'])) {
                    $params['thumbnail'] = join(',', array_replace($params['thumbnail'], $sized));
                } elseif (isset($params['resize'])) {
                    $params['resize'] = join(',', array_replace($params['resize'], $sized));
                } else {
                    $params['resize'] = join(',', $sized);
                }

                $sizes[] = $this->getUrl((string) $url->withQueryParams($params))." {$img->getWidth()}w";
            }
        }

        return $sizes;
    }

    /**
     * Gets the image info.
     *
     * @param  string $file
     * @return array
     */
    public static function getInfo($file)
    {
        if (isset(self::$cache[$file])) {
            return self::$cache[$file];
        }

        if ($info = @getimagesize($file)) {
            return self::$cache[$file] = [$info[0], $info[1], substr($info['mime'], 6)];
        }
    }
}
