<?php

return [

    'name' => 'yootheme/builder-divider',

    'builder' => 'divider',

    'render' => function ($element) {
        return $this['view']->render('@builder/divider/template', compact('element'));
    },

    'config' => [

        'title' => 'Divider',
        'width' => 500,
        'element' => true,
        'mixins' => ['element'],
        'tabs' => [

            [

                'title' => 'Content',
                'fields' => [

                    'divider_style' => [
                        'label' => 'Style',
                        'type' => 'checkbox',
                        'text' => 'Add an icon to the divider',
                    ],

                    'divider_style' => [
                        'label' => 'Style',
                        'description' => 'Choose a divider style.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Icon' => 'icon',
                            'Small' => 'small',
                        ],
                    ],

                    'divider_element' => [
                        'label' => 'HTML Element',
                        'description' => 'Choose the divider element to fit your semantic structure. Use the hr element for a thematic break and the div element for decorative reasons.',
                        'type' => 'select',
                        'options' => [
                            'Hr' => 'hr',
                            'Div' => 'div',
                        ],
                    ],

                    'divider_align' => [
                        'label' => 'Alignment',
                        'description' => 'Center, left and right alignment may depend on a breakpoint and require a fallback.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Inherit' => '',
                            'Left' => 'left',
                            'Center' => 'center',
                            'Right' => 'right',
                        ],
                        'show' => 'divider_style == "small"',
                    ],

                    'divider_align_breakpoint' => [
                        'label' => 'Alignment Breakpoint',
                        'description' => 'Define the device width from which the alignment will apply.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Always' => '',
                            'Small (Phone)' => 's',
                            'Medium (Tablet)' => 'm',
                            'Large (Desktop)' => 'l',
                            'X-Large (Large Screens)' => 'xl',
                        ],
                        'show' => 'divider_style == "small" && divider_align',
                    ],

                    'divider_align_fallback' => [
                        'label' => 'Alignment Fallback',
                        'description' => 'Define an alignment fallback for device widths below the breakpoint.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Inherit' => '',
                            'Left' => 'left',
                            'Center' => 'center',
                            'Right' => 'right',
                        ],
                        'show' => 'divider_style == "small" && divider_align && divider_align_breakpoint',
                    ],

                ],

            ],

            [

                'title' => 'Settings',
                'fields' => [

                    'maxwidth' => '{maxwidth}',

                    'maxwidth_align' => '{maxwidth_align}',

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

        'defaults' => [

            'divider_element' => 'hr',

        ],

    ],

];
