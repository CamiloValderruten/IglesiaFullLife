<?php

use YOOtheme\Theme\Builder;
use YOOtheme\Theme\ElementRenderer;
use YOOtheme\Theme\StyleRenderer;
use YOOtheme\Util\Arr;
use YOOtheme\Util\Collection;

return [

    'name' => 'yootheme/builder',

    'main' => function ($app) {

        $this['@data'] = function () {
            return new Collection();
        };

        $app['builder'] = function () {

            $builder = new Builder();

            foreach ($this['modules']->all() as $module) {
                if ($name = Arr::get($module->options, 'builder')) {

                    $options = $module->options;

                    if ($render = Arr::get($options, 'render')) {
                        if ($render instanceof \Closure) {
                            $options['render'] = $render->bindTo($module, $module);
                        }
                    }

                    $builder->add($name, $options);
                }
            }

            return $builder;
        };

    },

    'include' => [

        '../../builder/*/index.php'

    ],

    'routes' => function ($route) {

        $route->post('/builder/library', function ($id, $element, $response) {

            $this['option']->set("library.{$id}", Builder::encode($element, false));

            return $response->withJson(['message' => 'success']);
        });

        $route->delete('/builder/library', function ($id, $response) {

            $this['option']->remove("library.{$id}");

            return $response->withJson(['message' => 'success']);
        });

    },

    'events' => [

        'theme.site' => function ($theme) {

            $this['builder']
                ->addRenderer(new StyleRenderer)
                ->addRenderer(new ElementRenderer);

            if ($theme['@customizer']->isActive()) {

                $this['builder']->addRenderer(function ($element, $type, $next) {

                    static $id, $prefix;

                    if ($element->prefix) {
                        $id = 0; $prefix = $element->prefix;
                    }

                    $element->id = $prefix.$id++;

                    $content = $next($element, $type);

                    if (!in_array($element->type, ['layout', 'section', 'column', 'row'])) {
                        $content = preg_replace('/(^\s*<[^>]+)(>)/i', "$1 data-id=\"{$element->id}\"$2", $content, 1);
                    }

                    return $content;
                });

            }

        },

        'theme.admin' => [function ($theme) {

            foreach ($this['modules']->all() as $module) {
                if ($name = Arr::get($module->options, 'builder')) {
                    $this['@data']->set("types.{$name}", $module['@config']->all());
                }
            }

            $this['@data']->set('library', new Collection($this['option']->get('library')));
            $this['scripts']->add('customizer-builder', "{$this->path}/app/builder.min.js", 'customizer');

        }, -10],

        'view' => function () {
            if ($data = $this['@data']->all()) {
                $this['scripts']->add('builder-data', sprintf('var $builder = %s;', json_encode($data)), 'customizer-builder', 'string');
            }
        }

    ],

    'config' => [

        'section' => [
            'title' => 'Builder',
            'heading' => false,
            'width' => 600,
            'priority' => 20,
            'edit' => true,
        ]

    ]

];
