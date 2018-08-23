<?php

return [

    'name' => 'yootheme/builder-section',

    'builder' => 'section',

    'render' => function ($element) {
        return $this['view']->render('@builder/section/template', compact('element'));
    },

    'events' => [

        'theme.admin' => function () {
            $this['scripts']->add('builder-section', '@builder/section/app/section.min.js', 'customizer-builder');
        }

    ],

    'config' => [

        'title' => 'Section',
        'width' => 500,
        'fields' => [

            'style' => [
                'label' => 'Style',
                'type' => 'select',
                'options' => [
                    'Default' => 'default',
                    'Muted' => 'muted',
                    'Primary' => 'primary',
                    'Secondary' => 'secondary',
                    'Video' => 'video',
                ],
            ],

            'overlap' => [
                'type' => 'checkbox',
                'description' => 'Sections will only overlap each other, if it\'s supported by the style. Otherwise it has no visual effect.',
                'text' => 'Overlap the following section',
            ],

            'image' => [
                'label' => 'Image',
                'description' => 'Upload a background image.',
                'type' => 'image',
                'show' => 'style != "video"',
            ],

            'video' => [
                'label' => 'Video',
                'description' => 'Select an video file or enter a link from <a href="https://www.youtube.com" target="_blank">YouTube</a> or <a href="https://vimeo.com" target="_blank">Vimeo</a>.',
                'type' => 'video',
                'show' => 'style == "video"',
            ],

            'media' => [
                'type' => 'button-panel',
                'text' => 'Edit Settings',
                'panel' => 'builder-section-media',
                'show' => '(image && (style != "video")) || (video && (style == "video"))',
            ],

            'preserve_color' => [
                'label' => 'Text Color',
                'description' => 'Disable automatic text recoloring, for example when you use cards inside sections.',
                'type' => 'checkbox',
                'text' => 'Preserve color',
                'show' => 'style == "primary" || style == "secondary"',
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
                'show' => 'style != "primary" && style != "secondary" && (image && (style != "video")) || (video && (style == "video"))',
            ],

            'width' => [
                'label' => 'Max Width',
                'description' => 'Set the maximum content width.',
                'type' => 'select',
                'options' => [
                    'Default' => 'default',
                    'Small' => 'small',
                    'Large' => 'large',
                    'Expand' => 'expand',
                    'None' => '',
                ],
            ],

            'height' => [
                'label' => 'Height',
                'description' => 'Enabling viewport height on a section that directly follows the header will subtract the header\'s height from it and center the content. On short pages, a section can be expanded to fill the browser window.',
                'type' => 'select',
                'default' => '',
                'options' => [
                    'None' => '',
                    'Viewport' => 'full',
                    'Viewport (Minus 20%)' => 'percent',
                    'Viewport (Minus the following section)' => 'section',
                    'Expand' => 'expand',
                ],
            ],

            'padding' => [
                'label' => 'Padding',
                'description' => 'Set the vertical padding.',
                'type' => 'select',
                'default' => '',
                'options' => [
                    'Default' => '',
                    'X-Small' => 'xsmall',
                    'Small' => 'small',
                    'Large' => 'large',
                    'X-Large' => 'xlarge',
                    'None' => 'none',
                ],
            ],

            'padding_remove_top' => [
                'type' => 'checkbox',
                'text' => 'Remove top padding',
                'show' => 'padding != "none"',
            ],

            'padding_remove_bottom' => [
                'type' => 'checkbox',
                'text' => 'Remove bottom padding',
                'show' => 'padding != "none"',
            ],

            'header_transparent' => [
                'label' => 'Transparent Header',
                'description' => 'Turn the navbar and header transparent and overlay this section. Select dark or light text. Note: This only applies, if the section directly follows the header.',
                'type' => 'select',
                'default' => '',
                'options' => [
                    'None' => '',
                    'Overlay (Light)' => 'light',
                    'Overlay (Dark)' => 'dark',
                ],
            ],

            'animation' => [
                'label' => 'Animation',
                'description' => 'Apply an animation to elements once they enter the viewport. Slide animations can come into effect with a fixed offset or at 100% of the element\'s own size.',
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
            ],

            'animation_delay' => [
                'text' => 'Delay element animations.',
                'type' => 'checkbox',
            ],

            'id' => '{id}',

            'class' => '{class}',

            'name' => '{name}',
        ],

        'panels' => [

            'builder-section-media' => [
                'title' => 'Image/Video',
                'width' => 500,
                'fields' => [

                    'image_dimension' => [

                        'type' => 'grid',
                        'description' => 'Set the width and height in pixels (e.g. 600). Setting just one value preserves the original proportions. The image will be resized and cropped automatically.',
                        'fields' => [

                            'image_width' => [
                                'label' => 'Width',
                                'width' => '1-2',
                                'attrs' => [
                                    'placeholder' => 'auto',
                                    'lazy' => true,
                                ],
                            ],

                            'image_height' => [
                                'label' => 'Height',
                                'width' => '1-2',
                                'attrs' => [
                                    'placeholder' => 'auto',
                                    'lazy' => true,
                                ],
                            ],

                        ],
                        'show' => 'image && (style != "video")',

                    ],

                    'image_size' => [
                        'label' => 'Image Size',
                        'description' => 'Determine whether the image will fit the section dimensions by clipping it or by filling the empty areas with the background color.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Auto' => '',
                            'Cover' => 'cover',
                            'Contain' => 'contain',
                        ],
                        'show' => 'image && (style != "video")',
                    ],

                    'image_position' => [
                        'label' => 'Image Position',
                        'description' => 'Set the initial background position, relative to the section layer.',
                        'type' => 'select',
                        'options' => [
                            'Top Left' => 'top-left',
                            'Top Center' => 'top-center',
                            'Top Right' => 'top-right',
                            'Center Left' => 'center-left',
                            'Center Center' => 'center-center',
                            'Center Right' => 'center-right',
                            'Bottom Left' => 'bottom-left',
                            'Bottom Center' => 'bottom-center',
                            'Bottom Right' => 'bottom-right',
                        ],
                        'show' => 'image && (style != "video")',
                    ],

                    'image_fixed' => [
                        'label' => 'Image Attachment',
                        'text' => 'Fix the background with regard to the viewport.',
                        'type' => 'checkbox',
                        'show' => 'image && (style != "video")',
                    ],

                    'image_visibility' => [
                        'label' => 'Image Visibility',
                        'description' => 'Display the image only on this device width and larger.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Always' => '',
                            'Small (Phone)' => 's',
                            'Medium (Tablet)' => 'm',
                            'Large (Desktop)' => 'l',
                            'X-Large (Large Screens)' => 'xl',
                        ],
                        'show' => 'image && (style != "video")',
                    ],

                    'video_dimension' => [

                        'type' => 'grid',
                        'description' => 'Set the video dimensions.',
                        'fields' => [

                            'video_width' => [
                                'label' => 'Width',
                                'default' => '',
                                'width' => '1-2',
                             ],

                            'video_height' => [
                                'label' => 'Height',
                                'default' => '',
                                'width' => '1-2',
                            ],

                        ],
                        'show' => 'video && (style == "video")',

                    ],

                    'media_background' => [
                        'label' => 'Background Color',
                        'description' => 'Use the background color in combination with blend modes, a transparent image or to fill the area, if the image doesn\'t cover the whole section.',
                        'type' => 'color',
                    ],

                    'media_blend_mode' => [
                        'label' => 'Blend Mode',
                        'description' => 'Determine how the image or video will blend with the background color.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Normal' => '',
                            'Multiply' => 'multiply',
                            'Screen' => 'screen',
                            'Overlay' => 'overlay',
                            'Darken' => 'darken',
                            'Lighten' => 'lighten',
                            'Color-dodge' => 'color-dodge',
                            'Color-burn' => 'color-burn',
                            'Hard-light' => 'hard-light',
                            'Soft-light' => 'soft-light',
                            'Difference' => 'difference',
                            'Exclusion' => 'exclusion',
                            'Hue' => 'hue',
                            'Saturation' => 'saturation',
                            'Color' => 'color',
                            'Luminosity' => 'luminosity',
                        ],
                    ],

                    'media_overlay' => [
                        'label' => 'Overlay Color',
                        'description' => 'Set an additional transparent overlay to soften the image or video.',
                        'type' => 'color',
                    ],

                ],
            ],

        ],

        'defaults' => [

            'style' => 'default',
            'width' => 'default',
            'image_position' => 'center-center',

        ],

    ],

];
