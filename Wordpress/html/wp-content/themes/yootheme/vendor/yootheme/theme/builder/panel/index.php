<?php

return [

    'name' => 'yootheme/builder-panel',

    'builder' => 'panel',

    'render' => function ($element) {
        return $this['view']->render('@builder/panel/template', compact('element'));
    },

    'config' => [

        'title' => 'Panel',
        'width' => 500,
        'element' => true,
        'mixins' => ['element'],
        'tabs' => [

            [

                'title' => 'Content',
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

                    'image_dimension' => '{image_dimension}',

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

                    'link_target' => '{link_target}',

                    'link_text' => [
                        'label' => 'Link Text',
                        'description' => 'Enter the text for the link.',
                        'show' => 'link',
                    ],

                ],

            ],

            [

                'title' => 'Basic',
                'fields' => [

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
                        'show' => 'title',
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
                        'show' => 'title',
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
                        'show' => 'title',
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
                        'show' => 'title',
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
                        'show' => 'meta',
                    ],

                    'meta_align' => [
                        'label' => 'Meta Alignment',
                        'description' => 'Align the meta text above or below the title.',
                        'type' => 'select',
                        'options' => [
                            'Top' => 'top',
                            'Bottom' => 'bottom',
                        ],
                        'show' => 'meta',
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
                        'show' => 'meta',
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
                        'show' => 'content',
                    ],

                    'image_card' => [
                        'label' => 'Image Padding',
                        'description' => 'Top, left or right aligned images can be attached to the card\'s edge. If the image is aligned to the left or right, it will also extend to cover the whole space.',
                        'type' => 'checkbox',
                        'text' => 'Align image without padding',
                        'show' => 'image && panel_style && image_align != "between"',
                    ],

                    'image_border' => '{image_border}',

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
                        'show' => 'image && !panel_style',
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
                        'show' => 'link && image && !panel_style && link_style == "panel"',
                    ],

                    'icon_ratio' => '{icon_ratio}',

                    'icon_color' => '{icon_color}',

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
                        'show' => 'image || icon',
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
                        'show' => '(image || icon) && (image_align == "left" || image_align == "right")',
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
                        'show' => '(image || icon) && (image_align == "left" || image_align == "right") && !(image_card && panel_style)',
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
                        'show' => '(image || icon) && (image_align == "left" || image_align == "right")',
                    ],

                    'image_vertical_align' => [
                        'label' => 'Vertical Alignment',
                        'description' => 'Vertically center grid cells.',
                        'type' => 'checkbox',
                        'text' => 'Center',
                        'show' => '(image || icon) && (image_align == "left" || image_align == "right")',
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
                        'show' => 'link',
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
                        'show' => 'link && link_style && link_style != "link-muted" && link_style != "panel"',
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

            'link_text' => 'Read more',

            'title_element' => 'h3',
            'meta_style' => 'meta',
            'meta_align' => 'bottom',
            'icon_ratio' => 4,
            'image_align' => 'top',
            'image_grid_width' => '1-2',
            'image_breakpoint' => 'm',
            'link_style' => 'default',

            'margin' => 'default',

        ],

    ],

    'default' => [

        'props' => [
            'title' => 'Panel',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
        ],

    ],

];
