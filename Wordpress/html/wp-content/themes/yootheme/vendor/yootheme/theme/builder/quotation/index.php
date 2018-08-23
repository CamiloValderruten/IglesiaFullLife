<?php

return [

    'name' => 'yootheme/builder-quotation',

    'builder' => 'quotation',

    'render' => function ($element) {
        return $this['view']->render('@builder/quotation/template', compact('element'));
    },

    'config' => [

        'title' => 'Quotation',
        'width' => 500,
        'element' => true,
        'mixins' => ['element'],
        'tabs' => [

            [

                'title' => 'Content',
                'fields' => [

                    'content' => [
                        'label' => 'Content',
                        'type' => 'editor',
                    ],

                    'author' => [
                        'label' => 'Author',
                        'description' => 'Enter the author\'s name.',
                    ],

                    'link' => [
                        'label' => 'Author Link',
                        'attrs' => [
                            'placeholder' => 'http://',
                        ],
                        'show' => 'author',
                    ],

                    'link_target' => [
                        'type' => 'checkbox',
                        'text' => 'Open the link in a new window',
                        'show' => 'author && link',
                    ],

                    'link_style' => [
                        'label' => 'Link Style',
                        'description' => 'Select the link style.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Muted' => 'muted',
                            'Reset' => 'reset',
                        ],
                        'show' => 'author && link',
                    ],

                    'footer' => [
                        'label' => 'Footer',
                        'description' => 'Enter an optional footer text.',
                    ],

                ],

            ],

            [

                'title' => 'Settings',
                'fields' => [

                    'text_align' => '{text_align_justify}',

                    'text_align_breakpoint' => '{text_align_breakpoint}',

                    'text_align_fallback' => '{text_align_justify_fallback}',

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

    ],

    'default' => [

        'props' => [
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        ],

    ],

];
