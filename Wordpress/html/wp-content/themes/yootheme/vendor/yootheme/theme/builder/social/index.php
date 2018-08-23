<?php

return [

    'name' => 'yootheme/builder-social',

    'builder' => 'social',

    'render' => function ($element) {
        return $this['view']->render('@builder/social/template', compact('element'));
    },

    'config' => [

        'title' => 'Social',
        'width' => 500,
        'element' => true,
        'mixins' => ['element', 'container'],
        'tabs' => [

            [

                'title' => 'Content',
                'fields' => [

                    'links.0' => [
                        'label' => 'Links',
                        'attrs' => [
                            'placeholder' => 'http://',
                        ],
                    ],

                    'links.1' => [
                        'attrs' => [
                            'placeholder' => 'http://',
                        ],
                    ],

                    'links.2' => [
                        'attrs' => [
                            'placeholder' => 'http://',
                        ],
                    ],

                    'links.3' => [
                        'attrs' => [
                            'placeholder' => 'http://',
                        ],
                    ],

                    'links.4' => [
                        'description' => 'Enter up to 5 links to your social profiles. A corresponding <a href="https://getuikit.com/docs/icon" target="_blank">UIkit brand icon</a> will be displayed automatically, if available. Links to email addresses and phone numbers, like mailto:info@example.com or tel:+491570156, are also supported.',
                        'attrs' => [
                            'placeholder' => 'http://',
                        ],
                    ],

                    'link_target' => [
                        'type' => 'checkbox',
                        'text' => 'Open links in a new window.',
                    ],

                    'link_style' => [
                        'label' => 'Style',
                        'type' => 'select',
                        'options' => [
                            'Default' => '',
                            'Button' => 'button',
                            'Link' => 'link',
                            'Link Muted' => 'muted',
                            'Link Reset' => 'reset',
                        ],
                    ],

                    'icon_ratio' => [
                        'label' => 'Size',
                        'description' => 'Enter a size ratio, if you want the icon to appear larger than the default font size, for example 1.5 or 2 to double the size.',
                        'attrs' => [
                            'placeholder' => '1',
                        ],
                        'show' => 'link_style != "button"',
                    ],

                    'gutter' => [
                        'label' => 'Gutter',
                        'description' => 'Set the grid gutter width.',
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

            'link_style' => 'button',
            'gutter' => 'small',
            'margin' => 'default',

        ]

    ],

    'default' => [

        'props' => [

            'links' => [
                'https://twitter.com',
                'https://facebook.com',
                'https://plus.google.com',
            ]

        ]

    ],

];
