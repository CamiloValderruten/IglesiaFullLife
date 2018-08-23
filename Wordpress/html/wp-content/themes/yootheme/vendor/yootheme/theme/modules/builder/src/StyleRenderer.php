<?php

namespace YOOtheme\Theme;

class StyleRenderer
{
    /**
     * @var int
     */
    protected $index = 0;

    /**
     * @var Stylesheet
     */
    protected $styles;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->styles = (new Stylesheet)->addPlugin([$this, 'plugin']);
    }

    /**
     * Builder renderer callback.
     *
     * @param  Element    $element
     * @param  Collection $type
     * @param  callable   $next
     * @return string
     */
    public function __invoke($element, $type, $next)
    {
        if ($styles = $type['config.styles']) {
            $this->styles->addRules($styles, ['element' => $element]);
        }

        $content = $next($element, $type);

        if ($element->type == 'layout' and $styles = (string) $this->styles) {
            $content .= "<style>\n{$styles}\n</style>";
        }

        return $content;
    }

    /**
     * Stylesheet plugin callback.
     *
     * @param Rule $rule
     */
    public function plugin($rule)
    {
        if (!$element = $rule->options['element']) {
            return;
        }

        $class = "{$element->type}-".$this->index++;
        $replace = function ($matches) use ($element) {
            return $element[$matches[1]];
        };

        $rule->selector = ".{$class} {$rule->selector}";
        $rule->style = array_map(function ($value) use ($replace) {
            return preg_replace_callback('/\@([A-Z0-9\._-]+)/i', $replace, $value);
        }, $rule->style);

        $element['class'] = array_merge([$class], (array) $element['class']);
    }
}
