<?php

return [

    'name' => 'yootheme/builder-column',

    'builder' => 'column',

    'render' => function ($element) {
        return $this['view']->render('@builder/column/template', compact('element'));
    },

    'events' => [

        'theme.admin' => function () {
            $this['scripts']->add('builder-column', '@builder/column/app/column.min.js', 'customizer-builder');
        }

    ],

    'config' => [

        'title' => 'Column',
        'width' => 500,
        'fields' => [

            'style' => [
                'label' => 'Style',
                'type' => 'select',
                'default' => '',
                'options' => [
                    'Blank' => '',
                    'Default' => 'default',
                    'Muted' => 'muted',
                    'Primary' => 'primary',
                    'Secondary' => 'secondary',
                ],
            ],

            'image' => '{image}',

            'image_dimension' => '{image_dimension}',

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
                'show' => 'image',
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
                'show' => 'image',
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
                'show' => 'image',
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
                'show' => 'style != "primary" && style != "secondary" && (!style || image)',
            ],

            'padding' => [
                'label' => 'Padding',
                'description' => 'Set the padding.',
                'type' => 'select',
                'default' => '',
                'options' => [
                    'Default' => '',
                    'Small' => 'small',
                    'Large' => 'large',
                    'None' => 'none',
                ],
                'show' => 'style || image',
            ],

        ],

       'defaults' => [

            'image_position' => 'center-center',

        ],

    ],

];
