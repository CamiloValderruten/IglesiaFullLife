<?php

return [

    'name' => 'yootheme/builder-map',

    'builder' => 'map',

    'render' => function ($element) {

        $markers = [];
        $options = ['title', 'content', 'hide', 'show_popup'];
        $leaflet = 'https://cdn.jsdelivr.net/leaflet/1.0.2';

        foreach ($element as $marker) {

            if (!$location = $marker['location']) {
                continue;
            }

            list($lat, $lng) = explode(',', $location);

            $markers[] = $marker->pick($options)->set('lat', (float) $lat)->set('lng', (float) $lng);
        }

        if ($center = reset($markers)) {
            $element['center'] = $center->pick(['lat', 'lng']);
        } else {
            $element['center'] = ['lat' => 53.5503, 'lng' => 10.0006];
        }

        $element['markers'] = array_values(array_filter($markers, function ($marker) {
            return !$marker['hide'];
        }));

        if ($key = $this['theme']->get('google_maps')) {
            $this['scripts']
                ->add('google-api', 'https://www.google.com/jsapi', [], ['defer' => true])
                ->add('google-maps', "var \$google_maps = '{$key}';", [], ['defer' => true, 'type' => 'string']);
        } else {
            $this['styles']->add('leaflet', "{$leaflet}/leaflet.css", [], ['defer' => true]);
            $this['scripts']->add('leaflet', "{$leaflet}/leaflet.js", [], ['defer' => true]);
        }

        $this['scripts']->add('builder-map', '@builder/map/app/map.min.js', [], ['defer' => true]);

        return $this['view']->render('@builder/map/template', compact('element'));
    },

    'config' => [

        'title' => 'Map',
        'width' => 500,
        'element' => true,
        'mixins' => ['element', 'container'],
        'tabs' => [

            [

                'title' => 'Content',
                'fields' => [

                    'content' => [
                        'label' => 'Markers',
                        'type' => 'content-items',
                        'item' => 'map_marker',
                        'title' => 'title',
                        'button' => 'Add Marker',
                    ],

                    'show_title' => [
                        'type' => 'checkbox',
                        'default' => true,
                        'text' => 'Show title',
                    ],

                    'type' => [
                        'label' => 'Type',
                        'description' => 'Choose a map type.',
                        'type' => 'select',
                        'options' => [
                            'Roadmap' => 'roadmap',
                            'Satellite' => 'satellite',
                        ]
                    ],

                    'zoom' => [
                        'label' => 'Zoom',
                        'description' => 'Set the initial resolution at which to display the map. 0 is fully zoomed out and 18 is at the highest resolution zoomed in.',
                        'type' => 'number',
                        'attrs' => [
                            'min' => 0,
                            'max' => 18,
                        ]
                    ],

                    'controls' => [
                        'label' => 'Controls',
                        'type' => 'checkbox',
                        'text' => 'Show map controls',
                    ],

                    'zooming' => [
                        'text' => 'Enable map zooming',
                        'type' => 'checkbox',
                    ],

                    'dragging' => [
                        'description' => 'Display the map controls and define whether the map can be zoomed or be dragged using the mouse wheel or touch.',
                        'text' => 'Enable map dragging',
                        'type' => 'checkbox',
                    ],

                    'height' => [
                        'label' => 'Height',
                        'description' => 'Set the height in pixels, e.g. 300.',
                        'type'  => 'text',
                    ],

                    'popup_max_width' => [
                        'label' => 'Popup max width',
                        'description' => 'Set a maximum width for the popup, e.g. 300.',
                        'type'  => 'text',
                    ],

                    'styler' => [

                        'type' => 'grid',

                        'fields' => [

                            'styler_lightness' => [
                                'label' => 'Lightness',
                                'width' => '1-4',
                            ],

                            'styler_hue' => [
                                'label' => 'Hue',
                                'width' => '1-4',
                            ],

                            'styler_saturation' => [
                                'label' => 'Saturation',
                                'width' => '1-4',
                            ],

                            'styler_gamma' => [
                                'label' => 'Gamma',
                                'width' => '1-4',
                            ],

                        ],
                        'show' => '$app.config.google_maps',

                    ],

                    'styler_invert_lightness' => [
                        'description' => 'Set percentage change in lightness and saturation (Between -100 and 100), the hue (e.g. #ff0000) and the amount of gamma correction (Between 0.01 and 10.0, where 1.0 applies no correction).',
                        'type' => 'checkbox',
                        'text' => 'Invert lightness',
                        'show' => '$app.config.google_maps',
                    ],

                ],

            ],

            [

                'title' => 'Settings',
                'fields' => [

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

            'type' => 'roadmap',
            'zoom' => 10,
            'controls' => true,
            'zooming' => false,
            'dragging' => false,

        ],

    ],

    'include' => [

        'yootheme/builder-map-marker' => [

            'builder' => 'map_marker',

            'config' => [

                'title' => 'Marker',
                'width' => 600,
                'mixins' => ['element', 'item'],
                'fields' => [

                    'location' => [
                        'label' => 'Location',
                        'type'  => 'location'
                    ],

                    'title' => [
                        'label' => 'Title',
                        'description' => ''
                    ],

                    'content' => [
                        'label' => 'Content',
                        'type' => 'editor',
                        'description' => 'Click the marker to open the popup content.'
                    ],

                    'hide' => [
                        'label' => 'Settings',
                        'type' => 'checkbox',
                        'text' => 'Hide marker',
                    ],

                    'show_popup' => [
                        'type' => 'checkbox',
                        'text' => 'Show popup on load',
                    ],

                ],

            ],

        ],

    ],

];
