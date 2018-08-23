<?php

namespace YOOtheme\Theme\Stylesheet;

use YOOtheme\Util\Collection;

class Rule
{
    /**
     * @var string
     */
    public $selector;

    /**
     * @var array
     */
    public $style;

    /**
     * @var array
     */
    public $options;

    /**
     * Constructor.
     *
     * @param string $selector
     * @param array  $style
     * @param array  $options
     */
    public function __construct($selector, $style = [], array $options = [])
    {
        $this->selector = $selector;
        $this->style = (array) $style;
        $this->options = new Collection($options);
    }

    /**
     * Stringify the rule.
     *
     * @return string
     */
    public function __toString()
    {
        $string = '';

        foreach ($this->style as $prop => $value) {

            $value = rtrim($value, ';');

            if (empty($value) && !is_numeric($value)) {
                continue;
            }

            $string .= is_string($prop) ? "\n{$prop}: {$value};" : "\n{$value};";
        }

        if ($string) {
            $string = "{$this->selector} {{$string}\n}";
        }

        return $string;
    }
}
