<?php

return [

    'name' => 'yootheme/builder-alert',

    'builder' => 'alert',

    'render' => function ($element) {
        return $this['view']->render('@builder/alert/template', compact('element'));
    },

    'config' => [

        'title' => 'Alert',
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

                    'content' => [
                        'label' => 'Content',
                        'type' => 'editor',
                    ],

                    'alert_style' => [
                        'label' => 'Style',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Primary' => 'primary',
                            'Success' => 'success',
                            'Warning' => 'warning',
                            'Danger' => 'danger',
                        ],
                    ],

                    'alert_size' => [
                        'type' => 'checkbox',
                        'text' => 'Increase the padding of the alert box.',
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

            ]

        ]

    ],

    'default' => [

        'props' => [
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        ],

    ],

];
