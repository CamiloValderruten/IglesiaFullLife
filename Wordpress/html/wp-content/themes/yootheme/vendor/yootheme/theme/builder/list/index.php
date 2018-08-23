<?php

return [

    'name' => 'yootheme/builder-list',

    'builder' => 'list',

    'render' => function ($element) {
        return $this['view']->render('@builder/list/template', compact('element'));
    },

    'config' => [

        'title' => 'List',
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
                        'item' => 'list_item',
                        'title' => 'content',
                    ],

                    'show_image' => [
                        'type' => 'checkbox',
                        'text' => 'Show the image',
                    ],

                    'show_link' => [
                        'description' => 'Show or hide content fields without the need to delete the content itself.',
                        'type' => 'checkbox',
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
                            'Bullet' => 'bullet',
                        ],
                    ],

                    'list_size' => [
                        'type' => 'checkbox',
                        'description' => 'Select the list style and add larger padding between items.',
                        'text' => 'Larger padding',
                    ],

                    'content_style' => [
                        'label' => 'Content Style',
                        'description' => 'Select a predefined text style, including color, size and font-family.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Bold' => 'bold',
                            'Muted' => 'muted',
                            'H1' => 'h1',
                            'H2' => 'h2',
                            'H3' => 'h3',
                            'H4' => 'h4',
                            'H5' => 'h5',
                            'H6' => 'h6',
                        ],
                    ],

                    'image_dimension' => [

                        'type' => 'grid',
                        'description' => 'Setting just one value preserves the original proportions. The image will be resized and cropped automatically and where possible, high resolution images will be auto-generated.',
                        'fields' => [

                            'image_width' => [
                                'label' => 'Image Width',
                                'width' => '1-2',
                                'attrs' => [
                                    'placeholder' => 'auto',
                                    'lazy' => true,
                                ],
                            ],

                            'image_height' => [
                                'label' => 'Image Height',
                                'width' => '1-2',
                                'attrs' => [
                                    'placeholder' => 'auto',
                                    'lazy' => true,
                                ],
                            ],

                        ],
                        'show' => 'show_image',

                    ],

                    'image_border' => [
                        'label' => 'Image Border',
                        'description' => 'Select the image\'s border style.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'None' => '',
                            'Circle' => 'circle',
                            'Rounded' => 'rounded',
                        ],
                        'show' => 'show_image',
                    ],

                    'icon_ratio' => [
                        'label' => 'Icon Size',
                        'description' => 'Enter a size ratio, if you want the icon to appear larger than the default font size, for example 1.5 or 2 to double the size.',
                        'attrs' => [
                            'placeholder' => '1',
                        ],
                        'show' => 'show_image',
                    ],

                    'image_align' => [
                        'label' => 'Image Alignment',
                        'description' => 'Align the image to the left or right.',
                        'type' => 'select',
                        'options' => [
                            'Left' => 'left',
                            'Right' => 'right',
                        ],
                        'show' => 'show_image',
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

            'show_image' => true,
            'show_link' => true,
            'image_align' => 'left',

        ],

    ],

    'default' => [

        'children' => array_fill(0, 3, [
            'type' => 'list_item',
        ])

    ],

    'include' => [

        'yootheme/builder-list-item' => [

            'builder' => 'list_item',

            'config' => [

                'title' => 'Item',
                'width' => 600,
                'mixins' => ['element', 'item'],
                'fields' => [

                    'content' => [
                        'label' => 'Content',
                        'type' => 'editor',
                    ],

                    'image' => '{image}',

                    'image_alt' => [
                        'label' => 'Image Alt',
                        'show' => 'image',
                    ],

                    'icon' => [
                        'label' => 'Icon',
                        'description' => 'Instead of using a custom image, you can click on the pencil to pick an icon from the icon library.',
                        'type' => 'icon',
                        'show' => '!image',
                    ],

                    'icon_color' => '{icon_color}',

                    'link' => '{link}',

                    'link_target' => '{link_target}',

                ],

            ],

            'default' => [

                'props' => [
                    'content' => 'Item',
                ],

            ],

        ],

    ],

];
