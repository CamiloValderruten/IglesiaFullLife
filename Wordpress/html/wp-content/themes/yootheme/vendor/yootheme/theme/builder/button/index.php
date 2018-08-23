<?php

return [

    'name' => 'yootheme/builder-button',

    'builder' => 'button',

    'render' => function ($element) {
        return $this['view']->render('@builder/button/template', compact('element'));
    },

    'config' => [

        'title' => 'Button',
        'width' => 500,
        'element' => true,
        'mixins' => ['element', 'container'],
        'tabs' => [

            [

                'title' => 'Content',
                'fields' => [

                    'content' => [
                        'label' => 'Buttons',
                        'type' => 'content-items',
                        'item' => 'button_item',
                        'title' => 'content',
                        'button' => 'Add Button',
                    ],

                    'button_size' => [
                        'label' => 'Size',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Small' => 'small',
                            'Default' => '',
                            'Large' => 'large',
                        ],
                    ],

                    'fullwidth' => [
                        'type' => 'checkbox',
                        'text' => 'Full width button',
                    ],

                    'gutter' => [
                        'label' => 'Gutter',
                        'description' => 'Set the grid gutter for multiple buttons.',
                        'type' => 'select',
                        'options' => [
                            'Small' => 'small',
                            'Medium' => 'medium',
                            'Default' => '',
                            'Large' => 'large',
                        ],
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

            'gutter' => 'small',
            'margin' => 'default',

        ],

    ],

    'default' => [

        'children' => [
            [
                'type' => 'button_item',
                'props' => [
                    'content' => 'Button',
                    'button_style' => 'default',
                ],
            ],
        ],

    ],

    'include' => [

        'yootheme/button-item' => [

            'builder' => 'button_item',

            'config' => [

                'title' => 'Button',
                'width' => 600,
                'mixins' => ['element', 'item'],
                'fields' => [

                    'content' => [
                        'label' => 'Content',
                    ],

                    'link' => '{link}',

                    'link_target' => '{link_target}',

                    'link_title' => '{link_title}',

                    'icon' => [
                        'label' => 'Icon',
                        'description' => 'Pick an optional icon.',
                        'type' => 'icon',
                    ],

                    'icon_align' => [
                        'label' => 'Icon Alignment',
                        'description' => 'Choose the icon position.',
                        'type' => 'select',
                        'options' => [
                            'Left' => 'left',
                            'Right' => 'right',
                        ],
                        'show' => 'icon',
                    ],

                    'button_style' => [
                        'label' => 'Style',
                        'description' => 'Set the button style.',
                        'type' => 'select',
                        'options' => [
                            'Default' => 'default',
                            'Primary' => 'primary',
                            'Secondary' => 'secondary',
                            'Danger' => 'danger',
                            'Text' => 'text',
                            'Link' => '',
                            'Link Muted' => 'muted',
                        ],
                    ],

                ],

                'defaults' => [

                    'button_style' => 'default',
                    'icon_align'   => 'left'

                ],

            ],

            'default' => [

                'props' => [
                    'content' => 'Button'
                ],

            ],

        ],

    ],

];
