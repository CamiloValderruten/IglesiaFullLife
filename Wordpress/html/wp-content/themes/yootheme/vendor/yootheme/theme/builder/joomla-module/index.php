<?php

$config = [

    'name' => 'yootheme/builder-joomla-module',

    'builder' => 'joomla_module',

    'render' => function ($element) {

        $method = new ReflectionMethod('JModuleHelper', 'load');
        $method->setAccessible(true);

        foreach ($method->invoke(null) as $module) {
            if ($module->id === $element['module']) {
                $element->title = $module->title;
                $element->props = $module->config->merge($element->props, true);
                $element->content = JModuleHelper::renderModule($module);
                break;
            }
        }

        return $this['view']->render('@builder/joomla-module/template', compact('element'));
    },

    'config' => [

        'title' => 'J! Module',
        'width' => 500,
        'element' => true,
        'mixins' => ['element'],
        'tabs' => [

            [

                'title' => 'Content',
                'fields' => [

                    'module' => [
                        'label' => 'Module',
                        'description' => 'Any Joomla module can be displayed in your custom layout.',
                        'type' => 'select-module',
                        'default' => '',
                    ],

                ],

            ],

            [

                'title' => 'Settings',
                'fields' => [

                    'style' => [
                        'label' => 'Style',
                        'description' => 'Select one of the boxed card styles or a blank module.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Blank' => '',
                            'Card Default' => 'card-default',
                            'Card Primary' => 'card-primary',
                            'Card Secondary' => 'card-secondary',
                            'Card Hover' => 'card-hover',
                        ],
                    ],

                    'title_style' => [
                        'label' => 'Title Style',
                        'description' => 'Title styles differ in font-size but may also come with a predefined color, size and font.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Primary' => 'heading-primary',
                            'H1' => 'h1',
                            'H2' => 'h2',
                            'H3' => 'h3',
                            'H4' => 'h4',
                            'H5' => 'h5',
                            'H6' => 'h6',
                        ],
                    ],

                    'title_decoration' => [
                        'label' => 'Title Decoration',
                        'description' => 'Decorate the title with a divider, bullet or a line that is vertically centered to the heading.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'None' => '',
                            'Divider' => 'divider',
                            'Bullet' => 'bullet',
                            'Line' => 'line',
                        ],
                    ],

                    'title_color' => [
                        'label' => 'Title Color',
                        'description' => 'Select the text color. If the background option is selected, styles that don\'t apply a background image use the primary color instead.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Muted' => 'muted',
                            'Primary' => 'primary',
                            'Success' => 'success',
                            'Warning' => 'warning',
                            'Danger' => 'danger',
                            'Background' => 'background',
                        ]
                    ],

                    'text_align' => '{text_align_justify}',

                    'text_align_breakpoint' => '{text_align_breakpoint}',

                    'text_align_fallback' => '{text_align_justify_fallback}',

                    'maxwidth' => '{maxwidth}',

                    'maxwidth_align' => '{maxwidth_align}',

                    'list_style' => [
                        'label' => 'List Style',
                        'description' => 'Select the list style.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Divider' => 'divider',
                        ],
                        'show' => '{list_match}',
                    ],

                    'link_style' => [
                        'label' => 'Link Style',
                        'description' => 'Select the link style.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Muted' => 'muted',
                        ],
                        'show' => '{list_match}',
                    ],

                    'menu_style' => [
                        'label' => 'Menu Style',
                        'description' => 'Select the menu style',
                        'type' => 'select',
                        'default' => 'nav',
                        'options' => [
                            'Nav' => 'nav',
                            'Subnav' => 'subnav',
                        ],
                        'show' => '$match(type, "menu")',
                    ],

                    'margin' => '{margin}',

                    'margin_remove_top' => '{margin_remove_top}',

                    'margin_remove_bottom' => '{margin_remove_bottom}',

                    'animation' => '{animation}',

                    'visibility' => '{visibility}',

                    'id' => '{id}',

                    'class' => '{class}',

                    'name' => '{name}',

                ],

            ],

        ],

    ],

];

return defined('_JEXEC') ? $config : false;
