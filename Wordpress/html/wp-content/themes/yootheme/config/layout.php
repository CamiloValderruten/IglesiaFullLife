<?php

return [

    'fields' => [

        'layout' => [
            'type' => 'menu',
            'items' => [
                'site' => 'Site',
                'header' => 'Header',
                'mobile' => 'Mobile',
                'top' => 'Top',
                'sidebar' => 'Sidebar',
                'bottom' => 'Bottom',
                'footer' => 'Footer',
                'system-blog' => 'Blog',
                'system-post' => 'Post',
                'woocommere' => 'WooCommerce',
            ],
        ],

    ],

    'panels' => [

        'site' => [
            'title' => 'Site',
            'width' => 400,
            'fields' => [

                'logo.text' => [
                    'label' => 'Logo Text',
                    'description' => 'The logo text will be used, if no logo image has been picked.',
                ],

                'logo.image' => [
                    'label' => 'Logo Image',
                    'description' => 'Select your logo image.',
                    'type' => 'image',
                ],

                'logo.image_inverse' => [
                    'label' => 'Inverse Logo (Optional)',
                    'description' => 'Select an alternative logo with inversed color, e.g. white, for better visibility on dark backgrounds. It will be displayed automatically, if needed.',
                    'type' => 'image',
                ],

                'logo.image_mobile' => [
                    'label' => 'Mobile Logo (Optional)',
                    'description' => 'Select an alternative logo, which will be used on small devices.',
                    'type' => 'image',
                ],

                'site.layout' => [
                    'label' => 'Layout',
                    'description' => 'Note that the boxed page layout works best on large screens.',
                    'type' => 'select',
                    'options' => [
                        'Full Width' => 'full',
                        'Boxed Page' => 'boxed',
                    ],
                ],

                'site.boxed.alignment' => [
                    'type' => 'checkbox',
                    'text' => 'Center the page layout',
                    'show' => 'site.layout == "boxed"',
                ],

                'site.boxed.padding' => [
                    'type' => 'checkbox',
                    'text' => 'Add vertical padding to the page',
                    'show' => 'site.layout == "boxed"',
                ],

                'site.boxed.media' => [
                    'description' => 'Upload an optional background image that covers the page. It will be fixed while scrolling.',
                    'type' => 'image',
                    'show' => 'site.layout == "boxed"',
                ],

                'site.toolbar_fullwidth' => [
                    'label' => 'Toolbar',
                    'type' => 'checkbox',
                    'text' => 'Full width toolbar',
                ],

                'site.breadcrumbs' => [
                    'label' => 'Breadcrumbs',
                    'type' => 'checkbox',
                    'text' => 'Display the breadcrumb navigation',
                ],

            ],
        ],

        'header' => [
            'title' => 'Header',
            'width' => 400,
            'fields' => [

                'header.layout' => [
                    'label' => 'Layout',
                    'title' => 'Select header layout',
                    'type' => 'select-img',
                    'options' => [
                        'horizontal-left' => [
                            'label' => 'Horizontal Left',
                            'src' => '{+$assets}/images/header/horizontal-left.svg',
                        ],
                        'horizontal-center' => [
                            'label' => 'Horizontal Center',
                            'src' => '{+$assets}/images/header/horizontal-center.svg',
                        ],
                        'horizontal-right' => [
                            'label' => 'Horizontal Right',
                            'src' => '{+$assets}/images/header/horizontal-right.svg',
                        ],
                        'stacked-center-a' => [
                            'label' => 'Stacked Center A',
                            'src' => '{+$assets}/images/header/stacked-center-a.svg',
                        ],
                        'stacked-center-b' => [
                            'label' => 'Stacked Center B',
                            'src' => '{+$assets}/images/header/stacked-center-b.svg',
                        ],
                        'stacked-center-split' => [
                            'label' => 'Stacked Center Split',
                            'src' => '{+$assets}/images/header/stacked-center-split.svg',
                        ],
                        'stacked-left-a' => [
                            'label' => 'Stacked Left A',
                            'src' => '{+$assets}/images/header/stacked-left-a.svg',
                        ],
                        'stacked-left-b' => [
                            'label' => 'Stacked Left B',
                            'src' => '{+$assets}/images/header/stacked-left-b.svg',
                        ],
                        'toggle-offcanvas' => [
                            'label' => 'Toggle Offcanvas',
                            'src' => '{+$assets}/images/header/toggle-offcanvas.svg',
                        ],
                        'toggle-modal' => [
                            'label' => 'Toggle Modal',
                            'src' => '{+$assets}/images/header/toggle-modal.svg',
                        ],
                    ],
                ],

                'header.fullwidth' => [
                    'description' => 'Select a layout for the header and navbar.',
                    'type' => 'checkbox',
                    'text' => 'Full width header',
                ],

                'navbar.toggle_text' => [
                    'label' => 'Menu Toggle',
                    'type' => 'checkbox',
                    'text' => 'Show the menu text next to the icon',
                    'show' => 'header.layout == "toggle-offcanvas" || header.layout == "toggle-modal"',
                ],

                'navbar.offcanvas.mode' => [
                    'label' => 'Offcanvas Mode',
                    'type' => 'select',
                    'options' => [
                        'Slide' => 'slide',
                        'Reveal' => 'reveal',
                        'Push' => 'push',
                    ],
                    'show' => 'header.layout == "toggle-offcanvas"',
                ],

                'navbar.offcanvas.overlay' => [
                    'type' => 'checkbox',
                    'text' => 'Show the overlay',
                    'show' => 'header.layout == "toggle-offcanvas"',
                ],

                'navbar.sticky' => [
                    'label' => 'Navbar',
                    'type' => 'select',
                    'default' => 0,
                    'options' => [
                        'Static' => 0,
                        'Sticky' => 1,
                        'Sticky on scroll up' => 2,
                    ],
                ],

                'navbar.items' => [
                    'label' => 'Navbar Items',
                    'description' => 'Enter a subtitle, set the dropdown width and the number of dropdown columns for each navbar item.',
                    'type' => 'button-panel',
                    'text' => 'Edit Items',
                    'panel' => 'navbar-items',
                ],

                'navbar.dropdown_align' => [
                    'label' => 'Dropdown',
                    'type' => 'select',
                    'options' => [
                        'Left' => 'left',
                        'Right' => 'right',
                        'Center' => 'center',
                    ],
                ],

                'navbar.dropdown_boundary' => [
                    'type' => 'checkbox',
                    'text' => 'Align to navbar instead of the menu item',
                ],

                'navbar.dropdown_click' => [
                    'description' => 'Select the dropdown\'s alignment to the menu item or the navbar. If the dropdown sticks out of the viewport, it will be flipped automatically.',
                    'type' => 'checkbox',
                    'text' => 'Enable click mode on text separators',
                ],

                'navbar.dropbar' => [
                    'label' => 'Dropbar',
                    'description' => 'The dropbar converts the classic dropdown to a full-width section. The Push option behaves the same as Slide, if a transparent overlay header is enabled.',
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        'None' => '',
                        'Slide' => 'slide',
                        'Push' => 'push',
                    ],
                ],

                'header.search' => [
                    'label' => 'Search',
                    'description' => 'Select the position that will display the search.',
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        'Hide' => '',
                        'Header' => 'header',
                        'Navbar' => 'navbar',
                    ],
                ],

                'header.search_header' => [
                    'label' => 'Search Style',
                    'description' => 'Select the search style.',
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        'Default' => '',
//                        'Drop' => 'drop',
                        'Modal' => 'modal'
                    ],
                    'show' => 'header.search == "header" && $match(header.layout, "^stacked")',
                ],

                'header.search_navbar' => [
                    'label' => 'Search Style',
                    'description' => 'Select the search style.',
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        'Default' => '',
//                        'Drop' => 'drop',
//                        'Dropdown' => 'dropdown',
//                        'Justify' => 'justify',
                        'Modal' => 'modal',
                    ],
                    'show' => 'header.search && $match(header.layout, "^horizontal") || header.search == "navbar" && $match(header.layout, "^stacked")',
                ],

                'header.social' => [
                    'label' => 'Social',
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        'Hide' => '',
                        'Toolbar Left' => 'toolbar-left',
                        'Toolbar Right' => 'toolbar-right',
                        'Header' => 'header',
                        'Navbar' => 'navbar',
                    ],
                ],

                'header.social_links' => [
                    'type' => 'button-panel',
                    'text' => 'Edit Links',
                    'panel' => 'social-links',
                ],

                'header.social_target' => [
                    'type' => 'checkbox',
                    'text' => 'Open in a new window',
                ],

                'header.social_style' => [
                    'type' => 'checkbox',
                    'text' => 'Display icons as buttons',
                    'description' => 'Select the position that will display the social icons. Be sure to add your social profile links or no icons can be displayed.',
                ],

            ],
        ],

        'navbar-items' => [
            'title' => 'Navbar Items',
            'width' => 400,
            'fields' => [

                'items' => [
                    'type' => 'menu-items',
                    'position' => 'navbar',
                    'fields' => [

                        'subtitle' => [
                            'label' => 'Subtitle',
                            'description' => 'Enter a subtitle that will be displayed beneath the nav item.',
                            'type' => 'text',
                        ],

                        'columns' => [
                            'label' => 'Columns',
                            'description' => 'Split the dropdown into columns.',
                            'type' => 'select',
                            'level' => 0,
                            'default' => 1,
                            'options' => [
                                1 => 1,
                                2 => 2,
                                3 => 3,
                                4 => 4,
                                5 => 5,
                            ],
                        ],

                        'justify' => [
                            'label' => 'Width',
                            'description' => 'The justified dropdown expands to the navbar boundary.',
                            'type' => 'checkbox',
                            'text' => 'Justify dropdown',
                        ],

                    ],
                ],

            ],
        ],

        'social-links' => [
            'title' => 'Social',
            'width' => 400,
            'fields' => [

                'social_links.0' => [
                    'label' => 'Links',
                    'attrs' => [
                        'placeholder' => 'http://',
                    ],
                ],

                'social_links.1' => [
                    'attrs' => [
                        'placeholder' => 'http://',
                    ],
                ],

                'social_links.2' => [
                    'attrs' => [
                        'placeholder' => 'http://',
                    ],
                ],

                'social_links.3' => [
                    'attrs' => [
                        'placeholder' => 'http://',
                    ],
                ],

                'social_links.4' => [
                    'description' => 'Enter up to 5 links to your social profiles. A corresponding <a href="https://getuikit.com/docs/icon" target="_blank">UIkit brand icon</a> will be displayed automatically, if available. Links to email addresses and phone numbers, like mailto:info@example.com or tel:+491570156, are also supported.',
                    'attrs' => [
                        'placeholder' => 'http://',
                    ],
                ],

            ],
        ],

        'mobile' => [
            'title' => 'Mobile',
            'width' => 400,
            'fields' => [

                'mobile.breakpoint' => [
                    'label' => 'Breakpoint',
                    'description' => 'Select the device size that will replace the header with the mobile layout.',
                    'type' => 'select',
                    'options' => [
                        'Small' => 's',
                        'Medium' => 'm',
                        'Large' => 'l',
                    ],
                ],

                'mobile.logo' => [
                    'label' => 'Logo',
                    'description' => 'Select the alignment of the logo.',
                    'type' => 'select',
                    'options' => [
                        'Hide' => '',
                        'Left' => 'left',
                        'Center' => 'center',
                        'Right' => 'right',
                    ],
                ],

//                'mobile.search' => [
//                    'label' => 'Search',
//                    'description' => 'Select the alignment of the search.',
//                    'type' => 'select',
//                    'options' => [
//                        'Hide' => '',
//                        'Left' => 'left',
//                        'Right' => 'right',
//                    ],
//                ],

                'mobile.toggle' => [
                    'label' => 'Menu Toggle',
                    'type' => 'select',
                    'options' => [
                        'Hide' => '',
                        'Left' => 'left',
                        'Right' => 'right',
                    ],
                ],

                'mobile.toggle_text' => [
                    'description' => 'Select the alignment of the menu toggle icon. The toggle will only show up, if content is published in the mobile position.',
                    'type' => 'checkbox',
                    'text' => 'Show the menu text next to the icon',
                    'show' => 'mobile.toggle',
                ],

                'mobile.animation' => [
                    'label' => 'Menu Animation',
                    'description' => 'Select the menu type displayed in the mobile position.',
                    'type' => 'select',
                    'options' => [
                        'Offcanvas' => 'offcanvas',
                        'Modal' => 'modal',
                        'Dropdown' => 'dropdown',
                    ],
                ],

                'mobile.offcanvas.mode' => [
                    'label' => 'Offcanvas Mode',
                    'type' => 'select',
                    'options' => [
                        'Slide' => 'slide',
                        'Reveal' => 'reveal',
                        'Push' => 'push',
                    ],
                    'show' => 'mobile.animation == "offcanvas"',
                ],

                'mobile.offcanvas.flip' => [
                    'type' => 'checkbox',
                    'text' => 'Display on the right',
                    'show' => 'mobile.animation == "offcanvas"',
                ],

                'mobile.offcanvas.overlay' => [
                    'type' => 'checkbox',
                    'text' => 'Show the overlay',
                    'show' => 'mobile.animation == "offcanvas"',
                ],

                'mobile.dropdown' => [
                    'label' => 'Dropdown Animation',
                    'type' => 'select',
                    'options' => [
                        'Slide' => 'slide',
                        'Push' => 'push',
                    ],
                    'show' => 'mobile.animation == "dropdown"',
                ],

            ],
        ],

        'top' => [
            'title' => 'Top',
            'width' => 400,
            'fields' => [

                'top.style' => [
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

                'top.overlap' => [
                    'type' => 'checkbox',
                    'description' => 'Sections will only overlap each other, if it\'s supported by the style. Otherwise it has no visual effect.',
                    'text' => 'Overlap the following section',
                ],

                'top.image' => [
                    'label' => 'Image',
                    'description' => 'Upload a background image.',
                    'type' => 'image',
                    'show' => 'top.style != "video"',
                ],

                'top.video' => [
                    'label' => 'Video',
                    'description' => 'Select an video file or enter a link from <a href="https://www.youtube.com" target="_blank">YouTube</a> or <a href="https://vimeo.com" target="_blank">Vimeo</a>.',
                    'type' => 'video',
                    'show' => 'top.style == "video"',
                ],

                'top.media' => [
                    'type' => 'button-panel',
                    'text' => 'Edit Settings',
                    'panel' => 'top-media',
                    'show' => '(top.image && (top.style != "video")) || (top.video && (top.style == "video"))',
                ],

                'top.preserve_color' => [
                    'label' => 'Text Color',
                    'description' => 'Disable automatic text recoloring, for example when you use cards inside sections.',
                    'type' => 'checkbox',
                    'text' => 'Preserve color',
                    'show' => 'top.style == "primary" || top.style == "secondary"',
                ],

                'top.text_color' => [
                    'label' => 'Text Color',
                    'description' => 'Set light or dark color mode for text, buttons and controls.',
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        'Default' => '',
                        'Light' => 'light',
                        'Dark' => 'dark',
                    ],
                    'show' => 'top.style != "primary" && top.style != "secondary" && (top.image && (top.style != "video")) || (top.video && (top.style == "video"))',
                ],

                'top.width' => [
                    'label' => 'Width',
                    'description' => 'Set the maximum content width.',
                    'type' => 'select',
                    'options' => [
                        'Default' => 'default',
                        'Small' => 'small',
                        'Large' => 'large',
                        'Expand' => 'expand',
                        'Full' => '',
                    ],
                ],

                'top.height' => [
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

                'top.padding' => [
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

                'top.padding_remove_top' => [
                    'type' => 'checkbox',
                    'text' => 'Remove top padding',
                    'show' => 'top.padding != "none"',
                ],

                'top.padding_remove_bottom' => [
                    'type' => 'checkbox',
                    'text' => 'Remove bottom padding',
                    'show' => 'top.padding != "none"',
                ],

                'top.header_transparent' => [
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

                'top.grid_gutter' => [
                    'label' => 'Grid',
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

                'top.grid_divider' => [
                    'description' => 'Set the grid gutter width and display dividers between grid cells.',
                    'type' => 'checkbox',
                    'text' => 'Display dividers between grid cells',
                ],

                'top.vertical_align' => [
                    'label' => 'Vertical Alignment',
                    'description' => 'Vertically center grid cells.',
                    'type' => 'checkbox',
                    'text' => 'Center',
                ],

                'top.match' => [
                    'label' => 'Panels',
                    'description' => 'Stretch the panel to match the height of the grid cell.',
                    'type' => 'checkbox',
                    'text' => 'Match height',
                    'show' => '!top.vertical_align',
                ],

                'top.breakpoint' => [
                    'label' => 'Breakpoint',
                    'description' => 'Set the breakpoint from which grid cells will stack.',
                    'type' => 'select',
                    'options' => [
                        'Small (Phone Landscape)' => 's',
                        'Medium (Tablet Landscape)' => 'm',
                        'Large (Desktop)' => 'l',
                        'X-Large (Large Screens)' => 'xl',
                    ],
                ],

            ],
        ],

        'top-media' => [
            'title' => 'Image/Video',
            'width' => 400,
            'fields' => [

                'top.image_dimension' => [

                    'type' => 'grid',
                    'description' => 'Set the width and height in pixels (e.g. 600). Setting just one value preserves the original proportions. The image will be resized and cropped automatically.',
                    'fields' => [

                        'top.image_width' => [
                            'label' => 'Width',
                            'width' => '1-2',
                            'attrs' => [
                                'placeholder' => 'auto',
                                'lazy' => true,
                            ],
                        ],

                        'top.image_height' => [
                            'label' => 'Height',
                            'width' => '1-2',
                            'attrs' => [
                                'placeholder' => 'auto',
                                'lazy' => true,
                            ],
                        ],

                    ],
                    'show' => 'top.image && (top.style != "video")',

                ],

                'top.image_size' => [
                    'label' => 'Image Size',
                    'description' => 'Determine whether the image will fit the section dimensions by clipping it or by filling the empty areas with the background color.',
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        'Auto' => '',
                        'Cover' => 'cover',
                        'Contain' => 'contain',
                    ],
                    'show' => 'top.image && (top.style != "video")',
                ],

                'top.image_position' => [
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
                    'show' => 'top.image && (top.style != "video")',
                ],

                'top.image_fixed' => [
                    'label' => 'Image Attachment',
                    'text' => 'Fix the background with regard to the viewport.',
                    'type' => 'checkbox',
                    'show' => 'top.image && (top.style != "video")',
                ],

                'top.image_visibility' => [
                    'label' => 'Visibility',
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
                    'show' => 'top.image && (top.style != "video")',
                ],

                'top.video_dimension' => [

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
                    'show' => 'top.video && (top.style == "video")',

                ],

                'top.media_background' => [
                    'label' => 'Background Color',
                    'description' => 'Use the background color in combination with blend modes, a transparent image or to fill the area, if the image doesn\'t cover the whole section.',
                    'type' => 'color',
                ],

                'top.media_blend_mode' => [
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

                'top.media_overlay' => [
                    'label' => 'Overlay Color',
                    'description' => 'Set an additional transparent overlay to soften the image or video.',
                    'type' => 'color',
                ],

            ],
        ],

        'sidebar' => [
            'title' => 'Sidebar',
            'width' => 400,
            'fields' => [

                'sidebar.width' => [
                    'label' => 'Width',
                    'description' => 'Set a sidebar width in percent and the content column will adjust accordingly. The width will not go below the Sidebar\'s min-width, which you can set in the Style section.',
                    'type' => 'select',
                    'options' => [
                        '20%' => '1-5',
                        '25%' => '1-4',
                        '33%' => '1-3',
                        '40%' => '2-5',
                        '50%' => '1-2',
                    ],
                ],

                'sidebar.breakpoint' => [
                    'label' => 'Breakpoint',
                    'description' => 'Set the breakpoint from which the sidebar and content will stack.',
                    'type' => 'select',
                    'options' => [
                        'Small (Phone Landscape)' => 's',
                        'Medium (Tablet Landscape)' => 'm',
                        'Large (Desktop)' => 'l',
                    ],
                ],

                'sidebar.first' => [
                    'label' => 'Order',
                    'type' => 'checkbox',
                    'text' => 'Move the sidebar to the left of the content',
                ],

                'sidebar.gutter' => [
                    'label' => 'Gutter',
                    'description' => 'Set the padding between sidebar and content.',
                    'type' => 'select',
                    'options' => [
                        'Default' => '',
                        'Small' => 'small',
                        'Large' => 'large',
                        'None' => 'collapse',
                    ],
                ],

                'sidebar.divider' => [
                    'label' => 'Divider',
                    'type' => 'checkbox',
                    'text' => 'Display a divider between sidebar and content',
                ],

            ],
        ],

        'bottom' => [
            'title' => 'Bottom',
            'width' => 400,
            'fields' => [

                'bottom.style' => [
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

                'bottom.overlap' => [
                    'type' => 'checkbox',
                    'description' => 'Sections will only overlap each other, if it\'s supported by the style. Otherwise it has no visual effect.',
                    'text' => 'Overlap the following section',
                ],

                'bottom.image' => [
                    'label' => 'Image',
                    'description' => 'Upload a background image.',
                    'type' => 'image',
                    'show' => 'bottom.style != "video"',
                ],

                'bottom.video' => [
                    'label' => 'Video',
                    'description' => 'Select an video file or enter a link from <a href="https://www.youtube.com" target="_blank">YouTube</a> or <a href="https://vimeo.com" target="_blank">Vimeo</a>.',
                    'type' => 'video',
                    'show' => 'bottom.style == "video"',
                ],

                'bottom.media' => [
                    'type' => 'button-panel',
                    'text' => 'Edit Settings',
                    'panel' => 'bottom-media',
                    'show' => '(bottom.image && (bottom.style != "video")) || (bottom.video && (bottom.style == "video"))',
                ],

                'bottom.preserve_color' => [
                    'label' => 'Text Color',
                    'description' => 'Disable automatic text recoloring, for example when you use cards inside sections.',
                    'type' => 'checkbox',
                    'text' => 'Preserve color',
                    'show' => 'bottom.style == "primary" || bottom.style == "secondary"',
                ],

                'bottom.text_color' => [
                    'label' => 'Text Color',
                    'description' => 'Set light or dark color mode for text, buttons and controls.',
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        'Default' => '',
                        'Light' => 'light',
                        'Dark' => 'dark',
                    ],
                    'show' => 'bottom.style != "primary" && bottom.style != "secondary" && (bottom.image && (bottom.style != "video")) || (bottom.video && (bottom.style == "video"))',
                ],

                'bottom.width' => [
                    'label' => 'Width',
                    'description' => 'Set the maximum content width.',
                    'type' => 'select',
                    'options' => [
                        'Default' => 'default',
                        'Small' => 'small',
                        'Large' => 'large',
                        'Expand' => 'expand',
                        'Full' => '',
                    ],
                ],

                'bottom.height' => [
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

                'bottom.padding' => [
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

                'bottom.padding_remove_top' => [
                    'type' => 'checkbox',
                    'text' => 'Remove top padding',
                    'show' => 'bottom.padding != "none"',
                ],

                'bottom.padding_remove_bottom' => [
                    'type' => 'checkbox',
                    'text' => 'Remove bottom padding',
                    'show' => 'bottom.padding != "none"',
                ],

                'bottom.grid_gutter' => [
                    'label' => 'Grid',
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

                'bottom.grid_divider' => [
                    'description' => 'Set the grid gutter width and display dividers between grid cells.',
                    'type' => 'checkbox',
                    'text' => 'Display dividers between grid cells',
                ],

                'bottom.vertical_align' => [
                    'label' => 'Vertical Alignment',
                    'description' => 'Vertically center grid cells.',
                    'type' => 'checkbox',
                    'text' => 'Center',
                ],

                'bottom.match' => [
                    'label' => 'Panels',
                    'description' => 'Stretch the panel to match the height of the grid cell.',
                    'type' => 'checkbox',
                    'text' => 'Match height',
                    'show' => '!bottom.vertical_align',
                ],

                'bottom.breakpoint' => [
                    'label' => 'Breakpoint',
                    'description' => 'Set the breakpoint from which grid cells will stack.',
                    'type' => 'select',
                    'options' => [
                        'Small (Phone Landscape)' => 's',
                        'Medium (Tablet Landscape)' => 'm',
                        'Large (Desktop)' => 'l',
                        'X-Large (Large Screens)' => 'xl',
                    ],
                ],

            ],
        ],

        'bottom-media' => [
            'title' => 'Image/Video',
            'width' => 400,
            'fields' => [

                'bottom.image_dimension' => [

                    'type' => 'grid',
                    'description' => 'Set the width and height in pixels (e.g. 600). Setting just one value preserves the original proportions. The image will be resized and cropped automatically.',
                    'fields' => [

                        'bottom.image_width' => [
                            'label' => 'Width',
                            'width' => '1-2',
                            'attrs' => [
                                'placeholder' => 'auto',
                                'lazy' => true,
                            ],
                        ],

                        'bottom.image_height' => [
                            'label' => 'Height',
                            'width' => '1-2',
                            'attrs' => [
                                'placeholder' => 'auto',
                                'lazy' => true,
                            ],
                        ],

                    ],
                    'show' => 'bottom.image && (bottom.style != "video")',

                ],

                'bottom.image_size' => [
                    'label' => 'Image Size',
                    'description' => 'Determine whether the image will fit the section dimensions by clipping it or by filling the empty areas with the background color.',
                    'type' => 'select',
                    'default' => '',
                    'options' => [
                        'Auto' => '',
                        'Cover' => 'cover',
                        'Contain' => 'contain',
                    ],
                    'show' => 'bottom.image && (bottom.style != "video")',
                ],

                'bottom.image_position' => [
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
                    'show' => 'bottom.image && (bottom.style != "video")',
                ],

                'bottom.image_fixed' => [
                    'label' => 'Image Attachment',
                    'text' => 'Fix the background with regard to the viewport.',
                    'type' => 'checkbox',
                    'show' => 'bottom.image && (bottom.style != "video")',
                ],

                'bottom.image_visibility' => [
                    'label' => 'Visibility',
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
                    'show' => 'bottom.image && (bottom.style != "video")',
                ],

                'bottom.video_dimension' => [

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
                    'show' => 'bottom.video && (bottom.style == "video")',

                ],

                'bottom.media_background' => [
                    'label' => 'Background Color',
                    'description' => 'Use the background color in combination with blend modes, a transparent image or to fill the area, if the image doesn\'t cover the whole section.',
                    'type' => 'color',
                ],

                'bottom.media_blend_mode' => [
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

                'bottom.media_overlay' => [
                    'label' => 'Overlay Color',
                    'description' => 'Set an additional transparent overlay to soften the image or video.',
                    'type' => 'color',
                ],

            ],
        ],

        'footer' => [
            'title' => 'Footer',
            'heading' => false,
            'width' => 600,
            'fields' => [

                'footer.content' => [
                    'title' => 'Footer',
                    'type' => 'builder',
                    'prefix' => 'footer',
                ],

            ],
        ],

    ],

    'defaults' => [

        'site' => [

            'layout' => 'full',

            'boxed' => [

                'alignment' => 1,

            ],

        ],

        'header' => [

            'layout' => 'horizontal-right',

        ],

        'navbar' => [

            'dropdown_align' => 'left',

            'offcanvas' => [

                'mode' => 'slide',
                'overlay' => true,

            ],

        ],

        'mobile' => [

            'breakpoint' => 'm',
            'logo' => 'center',
            'toggle' => 'left',
            'search' => 'right',
            'animation' => 'offcanvas',

            'offcanvas' => [

                'mode' => 'slide',
                'overlay' => true,

            ],

            'dropdown' => 'slide',

        ],

        'top' => [

            'style' => 'default',
            'width' => 'default',
            'breakpoint' => 'm',
            'image_position' => 'center-center',

        ],

        'sidebar' => [

            'width' => '1-4',
            'min_width' => '200',
            'breakpoint' => 'm',
            'first' => 0,
            'gutter' => '',
            'divider' => 0,

        ],

        'bottom' => [

            'style' => 'default',
            'width' => 'default',
            'breakpoint' => 'm',
            'image_position' => 'center-center',

        ],

        'footer' => [

            'content' => '',

        ],

    ],

];
