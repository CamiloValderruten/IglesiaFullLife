<?php

return [

    'name' => 'yootheme/builder-html',

    'builder' => 'html',

    'render' => function ($element) {
        return "<div>{$element['content']}</div>";
    },

    'config' => [

        'title' => 'Html',
        'width' => 500,
        'element' => true,
        'mixins' => ['element'],
        'fields' => [

            'content' => [
                'label' => 'Content',
                'type' => 'editor',
            ],

        ],

    ],

    'default' => [

        'props' => [
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        ],

    ],

];
