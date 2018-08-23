<?php

namespace YOOtheme\View;

use YOOtheme\View;

class HtmlHelper
{
    static $selfClosing = ['input'];

    /**
     * Constructor.
     *
     * @param View $view
     */
    public function __construct(View $view)
    {
        $view->addFunction('tag', [$this, 'tag']);
        $view->addFunction('link', [$this, 'link']);
        $view->addFunction('image', [$this, 'image']);
        $view->addFunction('form', [$this, 'form']);
        $view->addFunction('attrs', [$this, 'attrs']);
    }

    /**
     * Renders a tag.
     *
     * @param  string $name
     * @param  array  $attrs
     * @param  string $text
     * @return string
     */
    public function tag($name, array $attrs = [], $text = null)
    {
        return "<{$name}{$this->attrs($attrs)}" . (in_array($name, self::$selfClosing) ? '/>' : ">$text</{$name}>");
    }

    /**
     * Renders a link tag.
     *
     * @param  string $title
     * @param  string $url
     * @param  array  $attrs
     * @return string
     */
    public function link($title, $url = null, array $attrs = [])
    {
        return "<a{$this->attrs(['href' => $url], $attrs)}>{$title}</a>";
    }

    /**
     * Renders an image tag.
     *
     * @param  array|string $url
     * @param  array        $attrs
     * @return string
     */
    public function image($url, array $attrs = [])
    {
        $url = (array) $url;
        $path = array_shift($url);
        $params = $url ? (strpos($path, '?') ? '&' : '?') . http_build_query(array_map(function ($value) {
            return is_array($value) ? implode(',', $value) : $value;
        }, $url), '', '&') : '';

        if (empty($attrs['alt'])) {
            $attrs['alt'] = true;
        }

        return "<img{$this->attrs(['src' => $path.$params], $attrs)}>";
    }

    /**
     * Renders a form tag.
     *
     * @param  array $tags
     * @param  array $attrs
     * @return string
     */
    public function form($tags, array $attrs = [])
    {
        return "<form{$this->attrs($attrs)}>\n" . implode("\n", array_map(function($tag) {
            return $this->tag($tag['tag'], array_diff_key($tag, ['tag' => null]));
        }, $tags)) . "\n</form>";
    }

    /**
     * Renders tag attributes.
     *
     * @param  array $attrs
     * @return string
     */
    public function attrs(array $attrs)
    {
        $output = [];

        if (count($args = func_get_args()) > 1) {
            $attrs = call_user_func_array('array_merge_recursive', $args);
        }

        foreach ($attrs as $key => $value) {

            if (is_array($value)) {
                $value = implode(' ', array_filter($value));
            }

            if (empty($value) && !is_numeric($value)) {
                continue;
            }

            if (is_numeric($key)) {
               $output[] = $value;
            } elseif ($value === true) {
               $output[] = $key;
            } elseif ($value !== '') {
               $output[] = sprintf('%s="%s"', $key, htmlspecialchars($value, ENT_COMPAT, 'UTF-8', false));
            }
        }

        return $output ? ' '.implode(' ', $output) : '';
    }
}
