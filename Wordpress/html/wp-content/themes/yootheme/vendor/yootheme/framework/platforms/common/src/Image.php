<?php

namespace YOOtheme;

use YOOtheme\Image\GDResource;

class Image
{
    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $file;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var Resource
     */
    protected $resource;

    /**
     * @var array
     */
    protected $operations = [];

    /**
     * Constructor.
     *
     * @param string $file
     * @param string $path
     * @param bool   $resource
     */
    public function __construct($file, $path = '', $resource = true)
    {
        $this->file = $file;
        $this->path = $path;

        list($this->width, $this->height, $this->type) = ImageProvider::getInfo($file);

        if ($resource) {
            if (is_callable('gd_info')) {
                $this->resource = new GDResource($file, $this->type);
            } else {
                throw new \RuntimeException('GD Extension not loaded');
            }
        }
    }

    /**
     * Gets the height.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Gets the width.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Gets the type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Gets the filename.
     *
     * @return string
     */
    public function getFile()
    {
        if ($hash = $this->getHash()) {

            $filename = pathinfo($this->file, PATHINFO_FILENAME);
            $extension = pathinfo($this->file, PATHINFO_EXTENSION);

            return sprintf('%s/%s-%s.%s', $this->path, $filename, $hash, $extension);
        }

        return $this->file;
    }

    /**
     * Gets the hash.
     *
     * @return string|false
     */
    public function getHash()
    {
        return $this->operations ? hash('crc32b', serialize([$this->file, $this->operations])) : false;
    }

    /**
     * Crops the image.
     *
     * @param  int $width
     * @param  int $height
     * @param  int $x
     * @param  int $y
     * @return self
     */
    public function crop($width = null, $height = null, $x = 'center', $y = 'center')
    {
        $ratio = $this->width / $this->height;
        $width = $this->parseValue($width, $this->width);
        $height = $this->parseValue($height, $this->height);

        if ($ratio > ($width / $height)) {
            $this->resize(round($height * $ratio), $height);
        } else {
            $this->resize($width, round($width / $ratio));
        }

        if ($x == 'left') {
            $x = 0;
        } elseif ($x == 'right') {
            $x = $this->width - $width;
        } elseif ($x == 'center') {
            $x = ($this->width - $width) / 2;
        }

        if ($y == 'top') {
            $y = 0;
        } elseif ($y == 'bottom') {
            $y = $this->height - $height;
        } elseif ($y == 'center') {
            $y = ($this->height - $height) / 2;
        }

        return $this->doCrop($this->width = $width, $this->height = $height, intval($x), intval($y));
    }

    /**
     * Resizes the image.
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $background
     * @return self
     */
    public function resize($width = null, $height = null, $background = 'crop')
    {
        $width = $this->parseValue($width, $this->width);
        $height = $this->parseValue($height, $this->height);

        if ($this->width != $width) {
            $scale = $this->width / $width;
        }

        if ($this->height != $height) {
            $scale = isset($scale) ? max($scale, $this->height / $height) : $this->height / $height;
        }

        if (!isset($scale)) {
            $scale = 1.0;
        }

        $dstWidth = intval(round($this->width / $scale));
        $dstHeight = intval(round($this->height / $scale));

        if ($background == 'cover') {
            return $this->crop($width, $height);
        }

        if ($background == 'fill') {
            return $this->doResize($this->width = $width, $this->height = $height, $width, $height);
        }

        if ($background == 'crop') {
            return $this->doResize($this->width = $dstWidth, $this->height = $dstHeight, $dstWidth, $dstHeight);
        }

        return $this->doResize($this->width = $width, $this->height = $height, $dstWidth, $dstHeight, $background);
    }

    /**
     * Thumbnail the image.
     *
     * @param  int $width
     * @param  int $height
     * @return self
     */
    public function thumbnail($width = null, $height = null)
    {
        return is_numeric($width) && is_numeric($height) ? $this->crop($width, $height) : $this->resize($width, $height);
    }

    /**
     * Run batch operations.
     *
     * @param  array $operations
     * @return self
     */
    public function batch(array $operations)
    {
        foreach ($operations as $name => $args) {
            call_user_func_array([$this, $name], $args);
        }
    }

    /**
     * Saves the image.
     *
     * @param  string $file
     * @param  string $type
     * @return self
     */
    public function save($file = null, $type = null)
    {
        $this->resource->save($file ?: $this->getFile(), $type);

        return $this;
    }

    /**
     * Handles dynamic method calls.
     *
     * @param  string $name
     * @param  array  $args
     * @return mixed
     */
    public function __call($name, $args)
    {
        if (method_exists('YOOtheme\Image\Resource', $name)) {
            $this->operations[] = "{$name}=".join(',', $args);
        }

        if (is_callable([$this->resource, $name])) {
            call_user_func_array([$this->resource, $name], $args);
        }

        return $this;
    }

    /**
     * Parses a percent value.
     *
     * @param  mixed $value
     * @param  int   $baseValue
     * @return int
     */
    protected function parseValue($value, $baseValue)
    {
        if (preg_match('/%$/', $value)) {
            $value = round($baseValue * (intval($value) / 100.0));
        }

        return intval($value) ?: $baseValue;
    }
}
