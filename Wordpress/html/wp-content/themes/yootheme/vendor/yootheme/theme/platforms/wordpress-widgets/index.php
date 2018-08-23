<?php

$config = [

    'name' => 'yootheme/wordpress-widgets',

    'main' => 'YOOtheme\\Theme\\Widgets',

    'config' => [

        'fields' => [

            'showtitle' => [
                'label' => 'Title',
                'type' => 'select',
                'default' => 0,
                'options' => [
                    'Show' => 1,
                    'Hide' => 0
                ],
            ],

            'class' => [
                'label' => 'Class',
            ],

        ],

        'defaults' => [],

    ],

];

return defined('WPINC') ? $config : false;
