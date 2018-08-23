<?php

namespace YOOtheme\Theme;

use YOOtheme\Util\Arr;

class ElementRenderer
{
    /**
     * Builder renderer callback.
     *
     * @param  BuilderElement $element
     * @param  Collection     $type
     * @param  callable       $next
     * @return string
     */
    public function __invoke($element, $type, $next)
    {
        $class = (array) $element['class'] ?: [];

        if (!$element['attrs']) {
            $element['attrs'] = [];
        }

        // Defaults
        if ($defaults = $type['config.defaults']) {
            $element->addProps($defaults);
        }

        // Default props
        if ($props = $type['default.props']) {

            $modified = Arr::some($props, function ($value, $key) use ($element) {
                return isset($element[$key]);
            });

            if (!$modified) {
                $element->addProps($props);
            }
        }

        // Default children
        if ($children = $type['default.children'] and !count($element)) {
            $element->addChildren($children);
        }

        // Animation
        if ($element['animation'] != 'none' && $element->parent('section', 'animation') && $element->parent->type == 'column') {
            $element['attrs.uk-scrollspy-class'] = $element['animation'] ? "uk-animation-{$element['animation']}" : true;
        }

        // Visibility
        if ($visibility = $element['visibility']) {
            $class[] = "uk-visible@{$visibility}";
        }

        // Margin
        if ($element->type != 'row') {
            switch ($element['margin']) {
                case '':
                    break;
                case 'default':
                    $class[] = 'uk-margin';
                    break;
                default:
                    $class[] = "uk-margin-{$element['margin']}";
            }
        }

        if ($element['margin'] != 'remove-vertical') {
            if ($element['margin_remove_top']) {
                $class[] = 'uk-margin-remove-top';
            }
            if ($element['margin_remove_bottom']) {
                $class[] = 'uk-margin-remove-bottom';
            }
        }

        // Max Width
        if ($maxwidth = $element['maxwidth']) {

            $class[] = "uk-width-{$maxwidth}";

            switch ($element['maxwidth_align']) {
                case 'right':
                    $class[] = "uk-margin-auto-left";
                    break;
                case 'center':
                    $class[] = "uk-margin-auto";
                    break;
            }
        }

        // Text alignment
        if ($element['text_align'] && $element['text_align'] != 'justify' && $element['text_align_breakpoint']) {
            $class[] = "uk-text-{$element['text_align']}@{$element['text_align_breakpoint']}";
            if ($element['text_align_fallback']) {
                $class[] = "uk-text-{$element['text_align_fallback']}";
            }
        } else if ($element['text_align']) {
            $class[] = "uk-text-{$element['text_align']}";
        }

        $element['class'] = $class;

        return $next($element, $type);
    }
}
