<?php

return [

    'name' => 'yootheme/builder-icon',

    'builder' => 'icon',

    'render' => function ($element) {
        return $this['view']->render('@builder/icon/template', compact('element'));
    },

    'config' => [

        'title' => 'Icon',
        'width' => 500,
        'element' => true,
        'mixins' => ['element'],
        'tabs' => [

            [

                'title' => 'Content',
                'fields' => [

                    'icon' => [
                        'label' => 'Icon',
                        'description' => 'Click on the pencil to pick an icon from the SVG gallery.',
                        'type' => 'icon',
                    ],

                    'icon_color' => [
                        'label' => 'Icon Color',
                        'description' => 'Select the icon\'s color.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Muted' => 'muted',
                            'Primary' => 'primary',
                            'Success' => 'success',
                            'Warning' => 'warning',
                            'Danger' => 'danger',
                        ],
                        'show' => '!link',
                    ],

                    'icon_ratio' => [
                        'label' => 'Icon Size',
                        'description' => 'Enter a size ratio, if you want the icon to appear larger than the default font size, for example 1.5 or 2 to double the size.',
                        'attrs' => [
                            'placeholder' => '1',
                        ],
                        'show' => 'link_style != "button"',
                    ],

                    'link' => '{link}',

                    'link_target' => '{link_target}',

                    'link_style' => [
                        'label' => 'Link Style',
                        'description' => 'Set the link style.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Button' => 'button',
                            'Link' => 'link',
                            'Link Muted' => 'muted',
                            'Link Reset' => 'reset',
                        ],
                        'show' => 'link',
                    ],

                ],

            ],

            [

                'title' => 'Settings',
                'fields' => [

                    'text_align' => '{text_align}',

                    'text_align_breakpoint' => '{text_align_breakpoint}',

                    'text_align_fallback' => '{text_align_fallback}',

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

            'icon' => 'star',

            'icon_ratio' => 3,

            'margin' => 'default',

        ],

    ],

];
