<?php

namespace YOOtheme\Theme\Stylesheet;

use YOOtheme\Util\Collection;

class RuleList
{
    /**
     * @var array
     */
    public $rules = [];

    /**
     * @var array
     */
    public $options;

    /**
     * Constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = new Collection($options);
    }

    /**
     * Adds a new rule.
     *
     * @param  string $selector
     * @param  array  $style
     * @param  array  $options
     * @return Rule
     */
    public function add($selector, $style, array $options = [])
    {
        $rule = new Rule($selector, $style, array_replace($this->options->all(), $options));

        $this->options['sheet']->runPlugins($rule);

        return $this->rules[] = $rule;
    }

    /**
     * Stringify the rule list.
     *
     * @return string
     */
    public function __toString()
    {
        $string = '';

        foreach ($this->rules as $rule) {

            if (!$str = (string) $rule) {
                continue;
            }

            if ($string) {
                $string .= "\n";
            }

            $string .= $str;
        }

        return $string;
    }
}
