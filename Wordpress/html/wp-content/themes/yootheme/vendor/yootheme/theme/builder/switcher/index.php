<?php

return [

    'name' => 'yootheme/builder-switcher',

    'builder' => 'switcher',

    'render' => function ($element) {
        return $this['view']->render('@builder/switcher/template', compact('element'));
    },

    'config' => [

        'title' => 'Switcher',
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
                        'item' => 'switcher_item',
                    ],

                    'show_title' => [
                        'label' => 'Display',
                        'type' => 'checkbox',
                        'text' => 'Show the title',
                    ],

                    'show_meta' => [
                        'type' => 'checkbox',
                        'text' => 'Show the meta text',
                    ],

                    'show_image' => [
                        'type' => 'checkbox',
                        'text' => 'Show the image',
                    ],

                    'show_content' => [
                        'type' => 'checkbox',
                        'text' => 'Show the content',
                    ],

                    'show_link' => [
                        'type' => 'checkbox',
                        'text' => 'Show the link',
                    ],

                    'show_label' => [
                        'type' => 'checkbox',
                        'text' => 'Show the navigation label',
                    ],

                    'show_thumbnail' => [
                        'description' => 'Show or hide content fields without the need to delete the content itself.',
                        'type' => 'checkbox',
                        'default' => true,
                        'text' => 'Show the navigation thumbnail',
                    ],

                ],

            ],

            [

                'title' => 'Basic',
                'fields' => [

                    'switcher_style' => [
                        'label' => 'Navigation',
                        'description' => 'Select the navigation style. The pill and line styles are only available for horizontal Subnavs.',
                        'type' => 'select',
                        'options' => [
                            'Tabs' => 'tab',
                            'Subnav Pill (Nav)' => 'subnav-pill',
                            'Subnav Divider (Nav)' => 'subnav-divider',
                            'Subnav (Nav)' => 'subnav',
                            'Thumbnails' => 'thumbnail',
                        ],
                    ],

                    'switcher_thumbnail_dimension' => [

                        'type' => 'grid',
                        'description' => 'Setting just one value preserves the original proportions. The image will be resized and cropped automatically and where possible, high resolution images will be auto-generated.',
                        'fields' => [

                            'switcher_thumbnail_width' => [
                                'label' => 'Thumbnail Width',
                                'width' => '1-2',
                                'attrs' => [
                                    'placeholder' => 'auto',
                                    'lazy' => true,
                                ],
                            ],

                            'switcher_thumbnail_height' => [
                                'label' => 'Thumbnail Height',
                                'width' => '1-2',
                                'attrs' => [
                                    'placeholder' => 'auto',
                                    'lazy' => true,
                                ],
                            ],

                        ],
                        'show' => 'switcher_style == "thumbnail" && show_thumbnail',

                    ],

                    'switcher_position' => [
                        'label' => 'Position',
                        'type' => 'select',
                        'options' => [
                            'Top' => 'top',
                            'Bottom' => 'bottom',
                            'Left' => 'left',
                            'Right' => 'right',
                        ],
                    ],

                    'switcher_style_primary' => [
                        'type' => 'checkbox',
                        'text' => 'Primary navigation',
                        'show' => '(switcher_position == "left" || switcher_position == "right") && $match(switcher_style, "(^subnav)")',
                    ],

                    'switcher_position_description' => [
                        'description' => 'Position the navigation at the top, bottom, left or right. A larger style can be applied to left and right navigations.',
                        'type' => 'description',
                    ],

                    'switcher_align' => [
                        'label' => 'Alignment',
                        'description' => 'Align the navigation\'s items.',
                        'type' => 'select',
                        'options' => [
                            'Left' => 'left',
                            'Right' => 'right',
                            'Center' => 'center',
                            'Justify' => 'justify',
                        ],
                    ],

                    'switcher_margin' => [
                        'label' => 'Margin',
                        'description' => 'Set the vertical margin.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Small' => 'small',
                            'Default' => '',
                            'Medium' => 'medium',
                            'Large' => 'large',
                            'X-Large' => 'xlarge',
                        ],
                        'show' => 'switcher_position == "top" || switcher_position == "bottom"',
                    ],

                    'switcher_grid_width' => [
                        'label' => 'Grid Width',
                        'description' => 'Define the width of the navigation. Choose between percent and fixed widths or expand columns to the width of their content.',
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
                        ],
                        'show' => 'switcher_position == "left" || switcher_position == "right"',
                    ],

                    'switcher_gutter' => [
                        'label' => 'Gutter',
                        'description' => 'Select the gutter width between the navigation and content items.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Small' => 'small',
                            'Medium' => 'medium',
                            'Default' => '',
                            'Large' => 'large',
                            'Collapse' => 'collapse',
                        ],
                        'show' => 'switcher_position == "left" || switcher_position == "right"',
                    ],

                    'switcher_breakpoint' => [
                        'label' => 'Breakpoint',
                        'description' => 'Set the breakpoint from which the navigation and content will stack.',
                        'type' => 'select',
                        'options' => [
                            'Small (Phone Landscape)' => 's',
                            'Medium (Tablet Landscape)' => 'm',
                            'Large (Desktop)' => 'l',
                        ],
                        'show' => 'switcher_position == "left" || switcher_position == "right"',
                    ],

                    'switcher_vertical_align' => [
                        'label' => 'Vertical Alignment',
                        'description' => 'Vertically center the navigation and content.',
                        'type' => 'checkbox',
                        'text' => 'Center',
                        'show' => 'switcher_position == "left" || switcher_position == "right"',
                    ],

                    'switcher_animation' => [
                        'label' => 'Animation',
                        'description' => 'Select an animation that will be applied to the content items when toggling between them.',
                        'type' => 'select',
                        'options' => [
                            'None' => '',
                            'Fade' => 'fade',
                            'Scale Up' => 'scale-up',
                            'Scale Down' => 'scale-down',
                            'Slide Top Small' => 'slide-top-small',
                            'Slide Bottom Small' => 'slide-bottom-small',
                            'Slide Left Small' => 'slide-left-small',
                            'Slide Right Small' => 'slide-right-small',
                            'Slide Top Medium' => 'slide-top-medium',
                            'Slide Bottom Medium' => 'slide-bottom-medium',
                            'Slide Left Medium' => 'slide-left-medium',
                            'Slide Right Medium' => 'slide-right-medium',
                            'Slide Top 100%' => 'slide-top',
                            'Slide Bottom 100%' => 'slide-bottom',
                            'Slide Left 100%' => 'slide-left',
                            'Slide Right 100%' => 'slide-right',
                        ],
                    ],

                    'switcher_height' => [
                        'label' => 'Match Height',
                        'description' => 'Extend content items to the same height.',
                        'type' => 'checkbox',
                        'text' => 'Match content height',
                    ],

                ],

            ],

            [

                'title' => 'Advanced',
                'fields' => [

                    'title_style' => [
                        'label' => 'Title Style',
                        'description' => 'Title styles differ in font-size but may also come with a predefined color, size and font.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Primary' => 'heading-primary',
                            'H1' => 'h1',
                            'H2' => 'h2',
                            'H3' => 'h3',
                            'H4' => 'h4',
                            'H5' => 'h5',
                            'H6' => 'h6',
                        ],
                        'show' => 'show_title',
                    ],

                    'title_decoration' => [
                        'label' => 'Title Decoration',
                        'description' => 'Decorate the title with a divider, bullet or a line that is vertically centered to the heading.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'None' => '',
                            'Divider' => 'divider',
                            'Bullet' => 'bullet',
                            'Line' => 'line',
                        ],
                        'show' => 'show_title',
                    ],

                    'title_color' => [
                        'label' => 'Title Color',
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
                        ],
                        'show' => 'show_title',
                    ],

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
                        'show' => 'show_title',
                    ],

                    'meta_style' => [
                        'label' => 'Meta Style',
                        'description' => 'Select a predefined meta text style, including color, size and font-family.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Meta' => 'meta',
                            'Muted' => 'muted',
                            'H4' => 'h4',
                            'H5' => 'h5',
                            'H6' => 'h6',
                        ],
                        'show' => 'show_meta',
                    ],

                    'meta_align' => [
                        'label' => 'Meta Alignment',
                        'description' => 'Align the meta text above or below the title.',
                        'type' => 'select',
                        'options' => [
                            'Top' => 'top',
                            'Bottom' => 'bottom',
                        ],
                        'show' => 'show_meta',
                    ],

                    'meta_margin' => [
                        'label' => 'Meta Margin',
                        'description' => 'Set the margin between title and meta text.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Small' => 'small',
                            'None' => 'remove',
                        ],
                        'show' => 'show_meta',
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

                    'image_box_shadow' => [
                        'label' => 'Image Box Shadow',
                        'description' => 'Select the image\'s box shadow size.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'None' => '',
                            'Small' => 'small',
                            'Medium' => 'medium',
                            'Large' => 'large',
                            'X-Large' => 'xlarge',
                        ],
                        'show' => 'show_image && !panel_style',
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
                            'Image/Card' => 'panel',
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

            'show_title' => true,
            'show_meta' => true,
            'show_content' => true,
            'show_image' => true,
            'show_link' => true,
            'show_label' => true,
            'show_thumbnail' => true,

            'switcher_style' => 'tab',
            'switcher_position' => 'top',
            'switcher_align' => 'left',
            'switcher_grid_width' => 'auto',
            'switcher_breakpoint' => 'm',
            'switcher_animation' => 'fade',
            'switcher_height' => true,

            'title_style' => 'h3',
            'title_element' => 'h3',
            'meta_style' => 'meta',
            'meta_align' => 'bottom',
            'image_align' => 'top',
            'image_grid_width' => '1-2',
            'image_breakpoint' => 'm',
            'switcher_thumbnail_width' => '100',
            'switcher_thumbnail_height' => '75',
            'link_text' => 'Read more',
            'link_style' => 'default',

            'margin' => 'default',

        ],

    ],

    'default' => [

        'children' => array_fill(0, 3, [
            'type' => 'switcher_item',
        ])

    ],

    'include' => [

        'yootheme/builder-switcher-item' => [

            'builder' => 'switcher_item',

            'config' => [

                'title' => 'Item',
                'width' => 600,
                'mixins' => ['element', 'item'],
                'fields' => [

                    'title' => [
                        'label' => 'Title',
                    ],

                    'meta' => [
                        'label' => 'Meta',
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

                    'link_text' => [
                        'label' => 'Alternative Link Text',
                        'show' => 'link',
                    ],

                    'label' => [
                        'label' => 'Navigation Label',
                    ],

                    'thumbnail' => [
                        'label' => 'Navigation Thumbnail',
                        'description' => 'Only used if thumbnail navigation is set.',
                        'type' => 'image',
                    ],

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
