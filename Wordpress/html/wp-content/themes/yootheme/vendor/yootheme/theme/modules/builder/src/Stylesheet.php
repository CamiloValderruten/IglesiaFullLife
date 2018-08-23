<?php

namespace YOOtheme\Theme;

use YOOtheme\Theme\Stylesheet\Rule;
use YOOtheme\Theme\Stylesheet\RuleList;

class Stylesheet
{
    /**
     * @var RuleList
     */
    protected $rules;

    /**
     * @var array
     */
    protected $plugins = [];

    /**
     * Constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->rules = new RuleList(array_replace($options, [
            'sheet' => $this,
            'parent' => $this,
        ]));
    }

    /**
     * Adds a rule.
     *
     * @param  string $selector
     * @param  array  $style
     * @param  array  $options
     * @return self
     */
    public function addRule($selector, $style, array $options = [])
    {
        $this->rules->add($selector, $style, $options);

        return $this;
    }

    /**
     * Adds multiple rules.
     *
     * @param  array $rules
     * @param  array $options
     * @return self
     */
    public function addRules(array $rules, array $options = [])
    {
        foreach ($rules as $selector => $style) {
            $this->rules->add($selector, $style, $options);
        }

        return $this;
    }

    /**
     * Adds a plugin.
     *
     * @param  callable $plugin
     * @return self
     */
    public function addPlugin(callable $plugin)
    {
        $this->plugins[] = $plugin;

        return $this;
    }

    /**
     * Runs all plugins.
     *
     * @param  Rule $rule
     * @return self
     */
    public function runPlugins(Rule $rule)
    {
        foreach ($this->plugins as $plugin) {
            $plugin($rule);
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->rules;
    }
}
