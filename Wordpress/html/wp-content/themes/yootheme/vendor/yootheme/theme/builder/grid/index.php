<?php

return [

    'name' => 'yootheme/builder-grid',

    'builder' => 'grid',

    'render' => function ($element) {
        return $this['view']->render('@builder/grid/template', compact('element'));
    },

    'config' => [

        'title' => 'Grid',
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
                        'item' => 'grid_item',
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
                        'description' => 'Show or hide content fields without the need to delete the content itself.',
                        'type' => 'checkbox',
                        'text' => 'Show the link',
                    ],

                ],

            ],

            [

                'title' => 'Basic',
                'fields' => [

                    'grid_default' => [
                        'label' => 'Phone Portrait',
                        'type' => 'select',
                        'default' => '1',
                        'options' => [
                            '1 Column' => '1',
                            '2 Columns' => '2',
                            '3 Columns' => '3',
                            '4 Columns' => '4',
                            '5 Columns' => '5',
                            '6 Columns' => '6',
                        ],
                    ],

                    'grid_small' => [
                        'label' => 'Phone Landscape',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Inherit' => '',
                            '1 Column' => '1',
                            '2 Columns' => '2',
                            '3 Columns' => '3',
                            '4 Columns' => '4',
                            '5 Columns' => '5',
                            '6 Columns' => '6',
                        ],
                    ],

                    'grid_medium' => [
                        'label' => 'Tablet Landscape',
                        'type' => 'select',
                        'default' => '3',
                        'options' => [
                            'Inherit' => '',
                            '1 Column' => '1',
                            '2 Columns' => '2',
                            '3 Columns' => '3',
                            '4 Columns' => '4',
                            '5 Columns' => '5',
                            '6 Columns' => '6',
                        ],
                    ],

                    'grid_large' => [
                        'label' => 'Desktop',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Inherit' => '',
                            '1 Column' => '1',
                            '2 Columns' => '2',
                            '3 Columns' => '3',
                            '4 Columns' => '4',
                            '5 Columns' => '5',
                            '6 Columns' => '6',
                        ],
                    ],

                    'grid_xlarge' => [
                        'label' => 'Large Screens',
                        'description' => 'Set the number of grid columns for each breakpoint. <i>Inherit</i> refers to the number of columns on the next smaller screen size.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Inherit' => '',
                            '1 Column' => '1',
                            '2 Columns' => '2',
                            '3 Columns' => '3',
                            '4 Columns' => '4',
                            '5 Columns' => '5',
                            '6 Columns' => '6',
                        ],
                    ],

                    'gutter' => [
                        'label' => 'Gutter',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Small' => 'small',
                            'Medium' => 'medium',
                            'Default' => '',
                            'Large' => 'large',
                            'Collapse' => 'collapse',
                        ],
                    ],

                    'divider' => [
                        'description' => 'Set the grid gutter width and display dividers between grid cells.',
                        'type' => 'checkbox',
                        'text' => 'Show dividers between the grid items',
                    ],

                    'panel_style' => [
                        'label' => 'Panel Style',
                        'description' => 'Select one of the boxed card styles or a blank panel.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Blank' => '',
                            'Card Default' => 'card-default',
                            'Card Primary' => 'card-primary',
                            'Card Secondary' => 'card-secondary',
                            'Card Hover' => 'card-hover',
                        ],
                    ],

                    'panel_size' => [
                        'label' => 'Panel Size',
                        'description' => 'Define the card\'s size by selecting the padding between the card and its content.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Small' => 'small',
                            'Default' => '',
                            'Large' => 'large',
                        ],
                        'show' => 'panel_style',
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
                            'Default' => '',
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

                    'image_card' => [
                        'label' => 'Image Padding',
                        'description' => 'Top, left or right aligned images can be attached to the card\'s edge. If the image is aligned to the left or right, it will also extend to cover the whole space.',
                        'type' => 'checkbox',
                        'text' => 'Align image without padding',
                        'show' => 'show_image && panel_style && image_align != "between"',
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

                    'image_hover_box_shadow' => [
                        'label' => 'Image Hover Box Shadow',
                        'description' => 'Select the image\'s box shadow size on hover.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'None' => '',
                            'Small' => 'small',
                            'Medium' => 'medium',
                            'Large' => 'large',
                            'X-Large' => 'xlarge',
                        ],
                        'show' => 'show_link && show_image && !panel_style && link_style == "panel"',
                    ],

                    'icon_ratio' => [
                        'label' => 'Icon Size',
                        'description' => 'Enter a size ratio, if you want the icon to appear larger than the default font size, for example 1.5 or 2 to double the size.',
                        'attrs' => [
                            'placeholder' => '1',
                        ],
                        'show' => 'show_image',
                    ],

                    'icon_color' => [
                        'label' => 'Icon Color',
                        'description' => 'Set the icon color.',
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
                            'Between' => 'between',
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
                        'show' => 'show_image && (image_align == "left" || image_align == "right") && !(image_card && panel_style)',
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
                        'show' => 'show_link && link_style && link_style != "link-muted" && link_style != "panel"',
                    ],

                ],

            ],

            [

                'title' => 'General',
                'fields' => [

                    'text_align' => '{text_align_justify}',

                    'text_align_breakpoint' => '{text_align_breakpoint}',

                    'text_align_fallback' => '{text_align_justify_fallback}',

                    'item_maxwidth' => '{maxwidth}',

                    'margin' => '{margin}',

                    'margin_remove_top' => '{margin_remove_top}',

                    'margin_remove_bottom' => '{margin_remove_bottom}',

                    'item_animation' => '{animation}',

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

            'grid_default' => '1',
            'grid_medium' => '3',

            'title_element' => 'h3',
            'meta_style' => 'meta',
            'meta_align' => 'bottom',
            'icon_ratio' => 4,
            'image_align' => 'top',
            'image_grid_width' => '1-2',
            'image_breakpoint' => 'm',
            'link_text' => 'Read more',
            'link_style' => 'default',

            'margin' => 'default',

        ],

    ],

    'default' => [

        'children' => array_fill(0, 3, [
            'type' => 'grid_item',
        ])

    ],

    'include' => [

        'yootheme/builder-grid-item' => [

            'builder' => 'grid_item',

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

                    'icon' => [
                        'label' => 'Icon',
                        'description' => 'Instead of using a custom image, you can click on the pencil to pick an icon from the icon library.',
                        'type' => 'icon',
                        'show' => '!image',
                    ],

                    'link' => '{link}',

                ],

            ],

            'default' => [

                'props' => [
                    'title' => 'Panel',
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                ],

            ],
        ],
    ],

];
