<?php

return [

    'name' => 'yootheme/builder-subnav',

    'builder' => 'subnav',

    'render' => function ($element) {
        return $this['view']->render('@builder/subnav/template', compact('element'));
    },

    'config' => [

        'title' => 'Subnav',
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
                        'item' => 'subnav_item',
                        'title' => 'content',
                    ],

                    'subnav_style' => [
                        'label' => 'Style',
                        'description' => 'Select the subnav style.',
                        'type' => 'select',
                        'default' => '',
                        'options' => [
                            'Default' => '',
                            'Divider' => 'divider',
                            'Pill' => 'pill',
                        ],
                    ],

                ],

            ],

            [

                'title' => 'Settings',
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

    ],

    'default' => [

        'children' => array_fill(0, 3, [
            'type' => 'subnav_item',
        ])

    ],

    'include' => [

        'yootheme/builder-subnav-item' => [

            'builder' => 'subnav_item',

            'config' => [

                'title' => 'Item',
                'width' => 600,
                'mixins' => ['element', 'item'],
                'fields' => [

                    'content' => [
                        'label' => 'Content',
                    ],

                    'link' => '{link}',

                    'link_target' => '{link_target}',

                ],

            ],

            'default' => [

                'props' => [
                    'content' => 'Item',
                ],

            ],

        ],

    ],

];
