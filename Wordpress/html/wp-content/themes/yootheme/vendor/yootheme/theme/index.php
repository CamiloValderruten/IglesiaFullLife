<?php

use YOOtheme\Http\Exception as HttpException;

const REGEX_VIMEO = '#(?:player\.)?vimeo\.com(?:/video)?/(\d+)#i';
const REGEX_YOUTUBE = '#(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})#i';

return [

    'name' => 'yootheme/theme',

    'main' => function ($app) {

        $app['locator']
            ->addPath("{$this->path}/builder", 'builder')
            ->addPath("{$this->path}/assets", 'assets')
            ->addPath("{$this->path}/platforms", 'assets/platforms');
    },

    'require' => 'yootheme/framework',

    'include' => [

        'modules/*/index.php',
        'platforms/*/index.php',

    ],

    'events' => [

        'init' => function () {
            $this['events']->trigger('theme.init', [$this['theme']]);
        },

        'theme.init' => function ($theme) {

            $this['assets']->setVersion($theme->options['version']);

            $this['scripts']
                ->register('vue', "{$this->path}/app/vue.min.js", 'config')
                ->register('uikit', 'vendor/assets/uikit/dist/js/uikit.min.js')
                ->register('uikit-icons', 'vendor/assets/uikit/dist/js/uikit-icons.min.js', '~uikit');
        },

        'theme.site' => function ($theme) {

            $this['view']->addFunction('social', function ($link) {

                static $icons;

                if (is_null($icons)) {
                    $icons = json_decode(file_get_contents("{$this->path}/app/data/icons.json"), true);
                    $icons = $icons['Brand Icons'];
                }

                if (strpos($link, 'mailto:') === 0) {
                    return 'mail';
                }

                if (strpos($link, 'tel:') === 0) {
                    return 'receiver';
                }

                $icon = parse_url($link, PHP_URL_HOST);
                $icon = preg_replace('/.*?(plus\.google|[^\.]+)\.[^\.]+$/i', '$1', $icon);
                $icon = str_replace('plus.google', 'google-plus', $icon);

                if (!in_array($icon, $icons)) {
                    $icon = 'social';
                }

                return $icon;
            });

            $this['view']->addFunction('iframeVideo', function ($link, $params = []) {

                $query = parse_url($link, PHP_URL_QUERY);

                if ($query) {
                    parse_str($query, $_params);
                    $params = array_merge($_params, $params);
                }

                if (preg_match(REGEX_VIMEO, $link, $matches)) {
                    return $this['url']->to("https://player.vimeo.com/video/{$matches[1]}", array_merge([
                        'loop' => 1, 'autoplay' => 1, 'title' => 0, 'byline' => 0, 'setVolume' => 0
                    ], $params));
                }

                if (preg_match(REGEX_YOUTUBE, $link, $matches)) {

                    if (!empty($params['loop'])) {
                        $params['playlist'] = $matches[1];
                    }

                    return $this['url']->to("https://www.youtube.com/embed/{$matches[1]}", array_merge([
                        'rel' => 0, 'loop' => 1, 'autoplay' => 1, 'controls' => 0, 'showinfo' => 0, 'modestbranding' => 1, 'wmode' => 'transparent'
                    ], $params));
                }

            });
        },

        'theme.admin' => [function ($theme) {

            $theme['@customizer']->mergeData([
                'name' => $theme->name,
                'base' => $this['url']->to($theme->path),
                'api' => 'https://yootheme.com/api',
            ]);

            foreach ($this['modules']->all() as $module) {

                if ($section = $module['@config']->get('section')) {

                    if ($fields = $module['@config']->get('fields')) {
                        $section['fields'] = $fields;
                    }

                    $theme['@customizer']->addSection(basename($module->name), $section);
                }

                if ($panels = $module['@config']->get('panels')) {
                    $theme['@customizer']->addData('panels', $panels);
                }

            }

            $this['translator']->addResource("{$this->path}/languages/{locale}.json");

        }, -10]

    ],

    'replacements' => [

        'id' => [
            'label' => 'ID',
            'description' => 'Define a unique identifier for the element.',
        ],

        'class' => [
            'label' => 'Class',
            'description' => 'Define one or more class names for the element. Separate multiple classes with spaces.',
        ],

        'name' => [
            'label' => 'Name',
            'description' => 'Define a name to easily indentify this element inside the builder.',
            'attrs' => ['lazy' => true],
        ],

        'animation' => [
            'label' => 'Animation',
            'description' => 'Override the section\'s animation setting. This option won\'t have any effect unless animations are enabled for this section.',
            'type' => 'select',
            'default' => '',
            'options' => [
                'Inherit' => '',
                'None' => 'none',
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

        'visibility' => [
            'label' => 'Visibility',
            'description' => 'Display the element only on this device width and larger.',
            'type' => 'select',
            'default' => '',
            'options' => [
                'Always' => '',
                'Small (Phone)' => 's',
                'Medium (Tablet)' => 'm',
                'Large (Desktop)' => 'l',
                'X-Large (Large Screens)' => 'xl',
            ],
        ],

        'margin' => [
            'label' => 'Margin',
            'description' => 'Set the vertical margin. Note: The first element\'s top margin and the last element\'s bottom margin are always removed. Define those in the grid settings instead.',
            'type' => 'select',
            'default' => '',
            'options' => [
                'Keep existing' => '',
                'Small' => 'small',
                'Default' => 'default',
                'Medium' => 'medium',
                'Large' => 'large',
                'X-Large' => 'xlarge',
                'None' => 'remove-vertical',
            ],
        ],

        'margin_remove_top' => [
            'type' => 'checkbox',
            'text' => 'Remove top margin',
            'show' => 'margin != "remove-vertical"',
        ],

        'margin_remove_bottom' => [
            'type' => 'checkbox',
            'text' => 'Remove bottom margin',
            'show' => 'margin != "remove-vertical"',
        ],

        'maxwidth' => [
            'label' => 'Max Width',
            'description' => 'Set the maximum content width.',
            'type' => 'select',
            'default' => '',
            'options' => [
                'None' => '',
                'Small' => 'small',
                'Medium' => 'medium',
                'Large' => 'large',
                'X-Large' => 'xlarge',
                'XX-Large' => 'xxlarge',
            ],
        ],

        'maxwidth_align' => [
            'label' => 'Block Alignment',
            'description' => 'Define the alignment in case the container exceeds the element\'s max-width.',
            'type' => 'select',
            'default' => '',
            'options' => [
                'Left' => '',
                'Center' => 'center',
                'Right' => 'right',
            ],
            'show' => 'maxwidth',
        ],

        'text_align' => [
            'label' => 'Text Alignment',
            'description' => 'Center, left and right alignment may depend on a breakpoint and require a fallback.',
            'type' => 'select',
            'default' => '',
            'options' => [
                'Inherit' => '',
                'Left' => 'left',
                'Center' => 'center',
                'Right' => 'right',
            ],
        ],

        'text_align_justify' => [
            'label' => 'Text Alignment',
            'description' => 'Center, left and right alignment may depend on a breakpoint and require a fallback.',
            'type' => 'select',
            'default' => '',
            'options' => [
                'Inherit' => '',
                'Left' => 'left',
                'Center' => 'center',
                'Right' => 'right',
                'Justify' => 'justify',
            ],
        ],

        'text_align_breakpoint' => [
            'label' => 'Text Alignment Breakpoint',
            'description' => 'Define the device width from which the alignment will apply.',
            'type' => 'select',
            'default' => '',
            'options' => [
                'Always' => '',
                'Small (Phone)' => 's',
                'Medium (Tablet)' => 'm',
                'Large (Desktop)' => 'l',
                'X-Large (Large Screens)' => 'xl',
            ],
            'show' => 'text_align && text_align != "justify"',
        ],

        'text_align_fallback' => [
            'label' => 'Text Alignment Fallback',
            'description' => 'Define an alignment fallback for device widths below the breakpoint.',
            'type' => 'select',
            'default' => '',
            'options' => [
                'Inherit' => '',
                'Left' => 'left',
                'Center' => 'center',
                'Right' => 'right',
            ],
            'show' => 'text_align && text_align_breakpoint',
        ],

        'text_align_justify_fallback' => [
            'label' => 'Alignment Fallback',
            'description' => 'Define an alignment fallback for device widths below the breakpoint.',
            'type' => 'select',
            'default' => '',
            'options' => [
                'Inherit' => '',
                'Left' => 'left',
                'Center' => 'center',
                'Right' => 'right',
                'Justify' => 'justify',
            ],
            'show' => 'text_align && text_align != "justify" && text_align_breakpoint',
        ],

        'link' => [
            'label' => 'Link',
            'attrs' => [
                'placeholder' => 'http://',
            ],
        ],

        'link_target' => [
            'type' => 'checkbox',
            'text' => 'Open the link in a new window',
        ],

        'link_title' => [
            'label' => 'Link Title',
            'description' => 'Enter an optional text for the title attribute of the link, which will appear on hover.',
        ],

        'image' => [
            'label' => 'Image',
            'type' => 'image',
            'show' => '!icon',
        ],

        'image_dimension' => [

            'type' => 'grid',
            'description' => 'Setting just one value preserves the original proportions. The image will be resized and cropped automatically and where possible, high resolution images will be auto-generated.',
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
            'show' => 'image',

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
            'show' => 'image',
        ],

        'icon_ratio' => [
            'label' => 'Icon Size',
            'description' => 'Enter a size ratio, if you want the icon to appear larger than the default font size, for example 1.5 or 2 to double the size.',
            'attrs' => [
                'placeholder' => '1',
            ],
            'show' => 'icon',
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
            'show' => 'icon',
        ],

    ],

];
