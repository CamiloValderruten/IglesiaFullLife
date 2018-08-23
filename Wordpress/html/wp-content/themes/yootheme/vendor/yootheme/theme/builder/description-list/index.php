<?php

return [

    'name' => 'yootheme/builder-description-list',

    'builder' => 'description_list',

    'render' => function ($element) {
        return $this['view']->render('@builder/description-list/template', compact('element'));
    },

    'config' => [

        'title' => 'Description List',
        'width' => 500,
        'element' => true,
        'mixins' => ['element', 'container'],
        'tabs' => [

            [

                'title' => 'Content',
                'fields' => [

                    'content' => [
                        'label' => 'Items',
                        'type' => 'content-items',
                        'item' => 'description_list_item',
                    ],

                    'show_link' => [
                        'description' => 'Show or hide content fields without the need to delete the content itself.',
                        'type' => 'checkbox',
                        'default' => true,
                        'text' => 'Show the link',
                    ],

                ],

            ],

            [

                'title' => 'Basic',
                'fields' => [

                    'list_style' => [
                        'label' => 'Style',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Divider' => 'divider',
                            'Striped' => 'striped',
                        ],
                    ],

                    'list_size' => [
                        'type' => 'checkbox',
                        'description' => 'Select the list style and add larger padding between items.',
                        'text' => 'Larger padding',
                    ],

                    'layout' => [
                        'label' => 'Layout',
                        'description' => 'Define the ratio of the term to the description.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Width Small' => 'width-small',
                            'Width Medium' => 'width-medium',
                            'Space Between' => 'space-between',
                            'Stacked' => 'stacked',
                        ]
                    ],

                    'gutter' => [
                        'label' => 'Gutter',
                        'description' => 'Select the gutter width between the title and content.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Small' => 'small',
                            'Medium' => 'medium',
                            'Default' => '',
                            'Large' => 'large',
                        ],
                        'show' => 'layout != "stacked"',
                    ],

                    'breakpoint' => [
                        'label' => 'Breakpoint',
                        'description' => 'Set the breakpoint from which the layout will stack.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Always' => '',
                            'Small (Phone)' => 's',
                            'Medium (Tablet)' => 'm',
                            'Large (Desktop)' => 'l',
                            'X-Large (Large Screens)' => 'xl',
                        ],
                        'show' => 'layout != "stacked"',
                    ],

                ],

            ],

            [

                'title' => 'Advanced',
                'fields' => [

                    'title_style' => [
                        'label' => 'Title Style',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Strong' => 'strong',
                            'Muted' => 'muted',
                            'H1' => 'h1',
                            'H2' => 'h2',
                            'H3' => 'h3',
                            'H4' => 'h4',
                            'H5' => 'h5',
                            'H6' => 'h6',
                        ]
                    ],

                    'title_colon' => [
                        'type' => 'checkbox',
                        'description' => 'Select the title style and add an optional colon at the end of the term.',
                        'text' => 'Add a colon',
                    ],

                    'content_style' => [
                        'label' => 'Content Style',
                        'description' => 'Select a predefined text style, including color, size and font-family.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Lead' => 'lead',
                            'Meta' => 'meta',
                        ],
                    ],

                    'link_style' => [
                        'label' => 'Link Style',
                        'description' => 'Set the link style. This only applies, if you\'ve added a URL to the item.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Muted' => 'muted',
                            'Reset' => 'reset',
                        ],
                        'show' => 'show_link',
                    ],

                ],

            ],

            [

                'title' => 'General',
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

            'show_link' => true,

        ],

    ],

    'default' => [

        'children' => array_fill(0, 3, [
            'type' => 'description_list_item',
        ]),

    ],

    'include' => [

        'yootheme/builder-description-list-item' => [

            'builder' => 'description_list_item',

            'config' => [

                'title' => 'Item',
                'width' => 600,
                'mixins' => ['element', 'item'],
                'fields' => [

                    'title' => [
                        'label' => 'Title',
                    ],

                    'content' => [
                        'label' => 'Content',
                        'type' => 'editor',
                    ],

                    'link' => '{link}',

                    'link_target' => '{link_target}',

                ],

            ],

            'default' => [

                'props' => [
                    'content' => 'Lorem ipsum dolor sit amet.',
                    'title' => 'Item',
                ],

            ],

        ],

    ],

];
