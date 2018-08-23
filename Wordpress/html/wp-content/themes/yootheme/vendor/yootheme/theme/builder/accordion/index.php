<?php

return [

    'name' => 'yootheme/builder-accordion',

    'builder' => 'accordion',

    'render' => function ($element) {
        return $this['view']->render('@builder/accordion/template', compact('element'));
    },

    'config' => [

        'title' => 'Accordion',
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
                        'item' => 'accordion_item',
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

                    'multiple' => [
                        'label' => 'Behavior',
                        'type' => 'checkbox',
                        'text' => 'Allow multiple open items',
                    ],

                    'collapsible' => [
                        'type' => 'checkbox',
                        'text' => 'Allow all items to be closed',
                    ],

                ],

            ],

            [

                'title' => 'Advanced',
                'fields' => [

                    'title_element' => [
                        'label' => 'Title HTML Element',
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

                    'content_style' => [
                        'label' => 'Content Style',
                        'description' => 'Select a predefined text style, including color, size and font-family.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Lead' => 'lead',
                        ],
                        'show' => 'show_content',
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

                    'image_align' => [
                        'label' => 'Image Alignment',
                        'description' => 'Align the image to the top, left, right or place it between the title and the content.',
                        'type' => 'select',
                        'options' => [
                            'Top' => 'top',
                            'Bottom' => 'bottom',
                            'Left' => 'left',
                            'Right' => 'right',
                        ],
                        'show' => 'show_image',
                    ],

                    'image_grid_width' => [
                        'label' => 'Grid Width',
                        'description' => 'Define the width of the image within the grid. Choose between percent and fixed widths or expand columns to the width of their content.',
                        'type' => 'select',
                        'options' => [
                            'Auto' => 'auto',
                            '50%' => '1-2',
                            '33%' => '1-3',
                            '25%' => '1-4',
                            '20%' => '1-5',
                            'Small' => 'small',
                            'Medium' => 'medium',
                            'Large' => 'large',
                            'X-Large' => 'xlarge',
                            'XX-Large' => 'xxlarge',
                        ],
                        'show' => 'show_image && (image_align == "left" || image_align == "right")',
                    ],

                    'image_gutter' => [
                        'label' => 'Gutter',
                        'description' => 'Select the gutter width between the image and content items.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Small' => 'small',
                            'Medium' => 'medium',
                            'Default' => '',
                            'Large' => 'large',
                            'Collapse' => 'collapse',
                        ],
                        'show' => 'show_image && (image_align == "left" || image_align == "right")',
                    ],

                    'image_breakpoint' => [
                        'label' => 'Breakpoint',
                        'description' => 'Set the breakpoint from which grid cells will stack.',
                        'type' => 'select',
                        'options' => [
                            'Small (Phone Landscape)' => 's',
                            'Medium (Tablet Landscape)' => 'm',
                            'Large (Desktop)' => 'l',
                        ],
                        'show' => 'show_image && (image_align == "left" || image_align == "right")',
                    ],

                    'image_vertical_align' => [
                        'label' => 'Vertical Alignment',
                        'description' => 'Vertically center grid cells.',
                        'type' => 'checkbox',
                        'text' => 'Center',
                        'show' => 'show_image && (image_align == "left" || image_align == "right")',
                    ],

                    'link_text' => [
                        'label' => 'Link Text',
                        'description' => 'Enter the text for the link.',
                        'show' => 'show_link',
                    ],

                    'link_target' => [
                        'type' => 'checkbox',
                        'text' => 'Open the link in a new window',
                        'show' => 'show_link',
                    ],

                    'link_style' => [
                        'label' => 'Link Style',
                        'description' => 'Set the link style.',
                        'type' => 'select',
                        'options' => [
                            'Link' => '',
                            'Link Muted' => 'link-muted',
                            'Button Default' => 'default',
                            'Button Primary' => 'primary',
                            'Button Secondary' => 'secondary',
                            'Button Danger' => 'danger',
                            'Button Text' => 'text',
                        ],
                        'show' => 'show_link',
                    ],

                    'link_size' => [
                        'label' => 'Button Size',
                        'description' => 'Set the button size.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Small' => 'small',
                            'Default' => '',
                            'Large' => 'large',
                        ],
                        'show' => 'show_link && link_style && link_style != "link-muted"',
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

            'collapsible' => true,

            'title_element' => 'h3',
            'image_align' => 'top',
            'image_grid_width' => '1-2',
            'image_breakpoint' => 'm',
            'link_text' => 'Read more',
            'link_style' => 'default',

        ],

    ],

    'default' => [

        'children' => array_fill(0, 3, [
            'type' => 'accordion_item',
        ]),

    ],

    'include' => [

        'yootheme/builder-accordion-item' => [

            'builder' => 'accordion_item',

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

                    'image' => '{image}',

                    'image_alt' => [
                        'label' => 'Image Alt',
                        'show' => 'image',
                    ],

                    'link' => '{link}',

                ],

            ],

            'default' => [

                'props' => [
                    'title' => 'Item',
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                ],

            ],

        ],

    ],

];
