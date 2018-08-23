<?php

return [

    'name' => 'yootheme/builder-code',

    'builder' => 'code',

    'render' => function ($element) {
        return $this['view']->render('@builder/code/template', compact('element'));
    },

    'config' => [

        'title' => 'Code',
        'width' => 500,
        'element' => true,
        'mixins' => ['element'],
        'tabs' => [

            [

                'title' => 'Content',
                'fields' => [

                    'content' => [
                        'label' => 'Content',
                        'type' => 'editor',
                        'editor' => 'code',
                        'attrs' => [],
                    ],

                ],

            ],

            [

                'title' => 'Settings',
                'fields' => [

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

        'props' => [
            'content' => '// Code example
<div id="myid" class="myclass" hidden>
    Lorem ipsum <strong>dolor</strong> sit amet, consectetur adipiscing elit.
</div>'
        ],

    ],

];
