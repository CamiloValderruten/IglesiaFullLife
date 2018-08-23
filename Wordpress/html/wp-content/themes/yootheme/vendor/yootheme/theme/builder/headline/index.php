<?php

return [

    'name' => 'yootheme/builder-headline',

    'builder' => 'headline',

    'render' => function ($element) {
        return $this['view']->render('@builder/headline/template', compact('element'));
    },

    'config' => [

        'title' => 'Headline',
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

                    'title_style' => [
                        'label' => 'Style',
                        'description' => 'Headline styles differ in font-size but may also come with a predefined color, size and font.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Primary' => 'heading-primary',
                            'Hero' => 'heading-hero',
                            'H1' => 'h1',
                            'H2' => 'h2',
                            'H3' => 'h3',
                            'H4' => 'h4',
                            'H5' => 'h5',
                            'H6' => 'h6',
                        ],
                    ],

                    'title_decoration' => [
                        'label' => 'Decoration',
                        'description' => 'Decorate the headline with a divider, bullet or a line that is vertically centered to the heading.',
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
                        'label' => 'Color',
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

                    'title_element' => [
                        'label' => 'HTML Element',
                        'description' => 'Choose one of the six heading elements to fit your semantic structure.',
                        'type' => 'select',
                        'options' => [
                            'H1' => 'h1',
                            'H2' => 'h2',
                            'H3' => 'h3',
                            'H4' => 'h4',
                            'H5' => 'h5',
                            'H6' => 'h6',
                        ],
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

        'defaults' => [

            'title_element' => 'h1',

        ],

    ],

    'default' => [

        'props' => [
            'content' => 'Headline',
        ],

    ],

];
