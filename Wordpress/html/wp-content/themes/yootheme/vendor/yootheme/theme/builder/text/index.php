<?php

return [

    'name' => 'yootheme/builder-text',

    'builder' => 'text',

    'render' => function ($element) {
        return $this['view']->render('@builder/text/template', compact('element'));
    },

    'config' => [

        'title' => 'Text',
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

                    'dropcap' => [
                        'label' => 'Drop Cap',
                        'description' => 'Display the first letter of the paragraph as a large initial.',
                        'type' => 'checkbox',
                        'text' => 'Enable drop cap',
                    ],

                    'column' => [
                        'label' => 'Columns',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'None' => '',
                            'Halves' => '1-2',
                            'Thirds' => '1-3',
                            'Quarters' => '1-4',
                            'Fifths' => '1-5',
                            'Sixths' => '1-6',
                        ],
                    ],

                    'column_divider' => [
                        'type' => 'checkbox',
                        'description' => 'Choose whether you want to apply a multi-column layout for the text.',
                        'text' => 'Show dividers between the text columns',
                        'show' => 'column',
                    ],

                    'column_breakpoint' => [
                        'label' => 'Columns Breakpoint',
                        'description' => 'Set the device width from which the text columns should apply. Note: For each breakpoint downward the number of columns will be reduced by one.',
                        'type' => 'select',
                        'options' => [
                            'Always' => '',
                            'Small (Phone Landscape)' => 's',
                            'Medium (Tablet Landscape)' => 'm',
                            'Large (Desktop)' => 'l',
                            'X-Large (Large Screens)' => 'xl',
                        ],
                        'show' => 'column',
                    ],

                ],

            ],

            [

                'title' => 'Settings',
                'fields' => [

                    'text_style' => [
                        'label' => 'Text Style',
                        'description' => 'Select a predefined text style, including color, size and font-family.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Lead' => 'lead',
                            'Meta' => 'meta',
                        ],
                    ],

                    'text_color' => [
                        'label' => 'Text Color',
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
                        ],
                        'show' => '!text_style',
                    ],

                    'text_size' => [
                        'label' => 'Text Size',
                        'description' => 'Select the text size.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Small' => 'small',
                            'Large' => 'large',
                        ],
                        'show' => '!text_style',
                    ],

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

            'column_breakpoint' => 'm',
            'margin' => 'default',

        ],

    ],

    'default' => [

        'props' => [
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        ],

    ],

];
