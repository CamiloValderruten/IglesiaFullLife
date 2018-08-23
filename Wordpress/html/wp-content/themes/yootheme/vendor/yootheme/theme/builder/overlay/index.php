<?php

return [

    'name' => 'yootheme/builder-overlay',

    'builder' => 'overlay',

    'render' => function ($element) {

        if (empty($element['image'])) {
            $element['image'] = $this['url']->to('@assets/images/element-image-placeholder.png');
        }

        return $this['view']->render('@builder/overlay/template', compact('element'));
    },

    'config' => [

        'title' => 'Overlay',
        'width' => 500,
        'element' => true,
        'mixins' => ['element'],
        'tabs' => [

            [

                'title' => 'Content',
                'fields' => [

                    'image' => '{image}',

                    'image_dimension' => '{image_dimension}',

                    'image_alt' => [
                        'label' => 'Image Alt',
                        'show' => 'image',
                    ],

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

                    'link' => '{link}',

                    'link_target' => '{link_target}',

                    'image2' => [
                        'label' => 'Second Image',
                        'description' => 'Select an optional second image that appears on hover.',
                        'type' => 'image',
                    ],

                ],

            ],

            [

                'title' => 'Basic',
                'fields' => [

                    'overlay_mode' => [
                        'label' => 'Mode',
                        'type' => 'select',
                        'options' => [
                            'Cover' => 'cover',
                            'Caption' => 'caption',
                        ],
                    ],

                    'overlay_hover' => [
                        'type' => 'checkbox',
                        'text' => 'Display overlay on hover',
                    ],

                    'overlay_transition_background' => [
                        'type' => 'checkbox',
                        'text' => 'Apply settings to background only',
                        'show' => 'overlay_hover && overlay_mode == "cover"',
                    ],

                    'overlay_mode_description' => [
                        'description' => 'When using cover mode, you need to set the text color manually.',
                        'type' => 'description',
                    ],

                    'overlay_style' => [
                        'label' => 'Style',
                        'description' => 'Select a style for the overlay.',
                        'type' => 'select',
                        'options' => [
                            'None' => '',
                            'Overlay Default' => 'overlay-default',
                            'Overlay Primary' => 'overlay-primary',
                            'Tile Default' => 'tile-default',
                            'Tile Muted' => 'tile-muted',
                            'Tile Primary' => 'tile-primary',
                            'Tile Secondary' => 'tile-secondary',
                        ],
                    ],

                    'text_color' => [
                        'label' => 'Text Color',
                        'description' => 'Set light or dark color mode for text, buttons and controls.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Light' => 'light',
                            'Dark' => 'dark',
                        ],
                        'show' => '!overlay_style || (overlay_style && overlay_mode == "cover")',
                    ],

                    'text_color_hover' => [
                        'type' => 'checkbox',
                        'text' => 'Inverse the text color on hover',
                        'show' => '(!overlay_style && image2) || (overlay_style && overlay_mode == "cover" && overlay_transition_background)',
                    ],

                    'overlay_padding' => [
                        'label' => 'Padding',
                        'description' => 'Set the padding between the overlay and its content.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Small' => 'small',
                            'Large' => 'large',
                            'None' => 'none',
                        ],
                    ],

                    'overlay_position' => [
                        'label' => 'Position',
                        'description' => 'Select the overlay or content position.',
                        'type' => 'select',
                        'options' => [
                            'Top' => 'top',
                            'Bottom' => 'bottom',
                            'Left' => 'left',
                            'Right' => 'right',
                            'Top Left' => 'top-left',
                            'Top Center' => 'top-center',
                            'Top Right' => 'top-right',
                            'Bottom Left' => 'bottom-left',
                            'Bottom Center' => 'bottom-center',
                            'Bottom Right' => 'bottom-right',
                            'Center' => 'center',
                            'Center Left' => 'center-left',
                            'Center Right' => 'center-right',
                        ],
                    ],

                    'overlay_margin' => [
                        'label' => 'Margin',
                        'description' => 'Apply a margin between the overlay and the image container.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'None' => '',
                            'Small' => 'small',
                            'Medium' => 'medium',
                        ],
                        'show' => 'overlay_style',
                    ],

                    'overlay_maxwidth' => [
                        'label' => 'Max Width',
                        'description' => 'Set the maximum content width.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'None' => '',
                            'Small' => 'small',
                            'Medium' => 'medium',
                            'Large' => 'large',
                            'X-Large' => 'large',
                        ],
                        'show' => '!$match(overlay_position, "(^cover$|^top$|^bottom$)")',
                    ],

                    'overlay_transition' => [
                        'label' => 'Transition',
                        'description' => 'Select a hover transition for the overlay.',
                        'type' => 'select',
                        'options' => [
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
                        'show' => 'overlay_hover',
                    ],

                ],

            ],

            [

                'title' => 'Advanced',
                'fields' => [

                    'image_transition' => [
                        'label' => 'Image Transition',
                        'description' => 'Select an image transition. If a second image is set, the transition takes place between the two images. If <i>None</i> is selected, the second image fades in.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'None (Fade if two images)' => '',
                            'Scale Up' => 'scale-up',
                            'Scale Down' => 'scale-down',
                        ],
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
                    ],

                    'title_transition' => [
                        'label' => 'Title Transition',
                        'description' => 'Select a hover transition for the title.',
                        'type' => 'select',
                        'default' => '',
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
                        'show' => 'overlay_hover',
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

                    'meta_transition' => [
                        'label' => 'Meta Transition',
                        'description' => 'Select a hover transition for the meta text.',
                        'type' => 'select',
                        'default' => '',
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
                        'show' => 'overlay_hover',
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

                    'content_transition' => [
                        'label' => 'Content Transition',
                        'description' => 'Select a hover transition for the content.',
                        'type' => 'select',
                        'default' => '',
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
                        'show' => 'overlay_hover',
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

                ],

            ],

            [

                'title' => 'General',
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

            'overlay_mode' => 'cover',
            'overlay_hover' => true,
            'overlay_style' => 'overlay-primary',
            'text_color' => 'light',
            'overlay_position' => 'center',
            'overlay_transition' => 'fade',

            'title_element' => 'h3',
            'meta_style' => 'meta',
            'meta_align' => 'bottom',

            'text_align' => 'center',
            'margin' => 'default',

        ],

    ],

    'default' => [

        'props' => [
            'title' => 'Overlay',
        ],

    ],

];
