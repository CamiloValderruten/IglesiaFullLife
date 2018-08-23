<?php

namespace YOOtheme\Theme;

use YOOtheme\Util\Collection;

class Builder
{
    /**
     * @var Collection
     */
    protected $types;

    /**
     * @var \SplStack
     */
    protected $renderer;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->types = new Collection();
        $this->renderer = new \SplStack();
        $this->renderer->push([$this, 'doRender']);
    }

    /**
     * Gets all element types.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->types;
    }

    /**
     * Gets an element type.
     *
     * @return Collection
     */
    public function get($name)
    {
        return $this->types[$name];
    }

    /**
     * Adds an element type.
     *
     * @param  string $name
     * @param  array  $type
     * @return self
     */
    public function add($name, $type)
    {
        $this->types[$name] = new Collection($type);

        return $this;
    }

    /**
     * Removes an element type.
     *
     * @param  string $name
     * @return self
     */
    public function remove($name)
    {
        unset($this->types[$name]);

        return $this;
    }

    /**
     * Loads an element.
     *
     * @param  Collection|array|string $element
     * @return BuilderElement
     */
    public function load($element)
    {
        if (is_string($element)) {
            $element = json_decode($element, true);
        } elseif ($element instanceof Collection) {
            $element = $element->all();
        }

        return is_array($element) ? new BuilderElement($element) : null;
    }

    /**
     * Renders an element.
     *
     * @param  string|array $element
     * @param  string       $prefix
     * @return string
     */
    public function render($element, $prefix = '')
    {
        if (!$element instanceof BuilderElement) {
            $element = $this->load($element);
        }

        if ($prefix && is_object($element)) {
            $element->prefix = "{$prefix}#";
        }

        return $element ? call_user_func($this->renderer->top(), $element, $this->get($element->type) ?: new Collection()) : '';
    }

    /**
     * Applies an element render callback.
     *
     * @param  BuilderElement $element
     * @param  Collection     $type
     * @return string
     */
    public function doRender(BuilderElement $element, Collection $type)
    {
        $reducer = function ($carry, $child) {
            return $carry.$this->render($child);
        };

        if (count($element)) {
            $element->content = array_reduce($element->children, $reducer, '');
        }

        return $type['render'] ? call_user_func($type['render'], $element) : (string) $element;
    }

    /**
     * Adds a renderer to stack.
     *
     * @param  callable $renderer
     * @return self
     */
    public function addRenderer(callable $renderer)
    {
        $next = $this->renderer->top();

        $this->renderer->push(function (BuilderElement $element, Collection $type) use ($renderer, $next) {
            return $renderer($element, $type, $next);
        });

        return $this;
    }

    /**
     * Converts elements to content.
     *
     * @param  array $elements
     * @return string
     */
    public static function content(array $elements)
    {
        $output = '';

        if (empty($elements[0])) {
            $elements = [$elements];
        }

        foreach ($elements as $element) {

            if (!empty($element['props']['content'])) {
                $output .= "<p>{$element['props']['content']}</p>\n\n";
            }

            if (!empty($element['children'])) {
                $output .= static::content($element['children']);
            }
        }

        return $output;
    }

    /**
     * Encodes an element to JSON.
     *
     * @param  array   $elements
     * @param  boolean $encode
     * @return string|array
     */
    public static function encode(array $elements, $encode = true)
    {
        $data = [];

        if ($root = empty($elements[0])) {
            $elements = [$elements];
        }

        foreach ($elements as $element) {

            $el = [
                'name' => @$element['name'] ?: '',
                'type' => @$element['type'] ?: '',
            ];

            if (!empty($element['props'])) {
                $el['props'] = $element['props'];
            }

            if (!empty($element['children'])) {
                $el['children'] = static::encode($element['children'], false);
            }

            $data[] = $el;
        }

        if ($root) {
            $data = $data[0];
        }

        return $encode ? json_encode($data) : $data;
    }
}
