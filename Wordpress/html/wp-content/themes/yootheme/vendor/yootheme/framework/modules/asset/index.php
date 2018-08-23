<?php

use YOOtheme\Asset\CssImageBase64Filter;
use YOOtheme\Asset\CssImportResolverFilter;
use YOOtheme\Asset\CssRewriteUrlFilter;
use YOOtheme\Asset\CssRtlFilter;
use YOOtheme\Asset\FilterManager;
use YOOtheme\AssetFactory;
use YOOtheme\AssetManager;
use YOOtheme\Util\File;
use YOOtheme\Util\Str;

return [

    'name' => 'yootheme/asset',

    'main' => function ($app) {

        $app['assets'] = function ($app) {
            return new AssetFactory($app['assets.loader']);
        };

        $app['assets.loader'] = $app->protect(function ($name) {

            $scheme = ['http://', 'https://', '//'];

            if (File::isAbsolute($name)) {
                return !Str::startsWith($name, $scheme) && is_file($name) ? $name : false;
            }

            if ($name[0] != '@') {
                $name = "@assets/{$name}";
            }

            return File::find($name);
        });

        $app['assets.filters'] = function ($app) {
            return new FilterManager([
                'CssImageBase64' => new CssImageBase64Filter($this['url']->base(), $app->path),
                'CssImportResolver' => new CssImportResolverFilter,
                'CssRewriteUrl' => new CssRewriteUrlFilter($app['url']),
                'CssRtl' => new CssRtlFilter,
            ]);
        };

        $app['styles'] = function ($app) {
            return new AssetManager($app['assets'], $app['assets.filters'], $app['styles.cache']);
        };

        $app['styles.cache'] = function ($app) {
            return isset($app['path.cache']) ? "{$app['path.cache']}/%name%.css" : null;
        };

        $app['scripts'] = function ($app) {
            return new AssetManager($app['assets'], $app['assets.filters'], $app['scripts.cache']);
        };

        $app['scripts.cache'] = function ($app) {
            return isset($app['path.cache']) ? "{$app['path.cache']}/%name%.js" : null;
        };

    },

    'events' => [

        'view' => [function ($app) {

            $config = [
                'url' => $this['url']->base(),
                'route' => $this['url']->route(),
            ];

            if (isset($this['locale'])) {
                $config['locale'] = $this['locale'];
            }

            if (isset($this['translator'])) {
                $config['locales'] = $this['translator']->getResources();
            }

            if (isset($this['csrf'])) {
                $config['csrf'] = $this['csrf']->generate();
            }

            $this['scripts']->register('config', sprintf('var $config = %s;', json_encode($config)), [], 'string');

        }, 10]

    ]

];
