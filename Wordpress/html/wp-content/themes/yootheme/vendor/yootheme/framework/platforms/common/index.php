<?php

use YOOtheme\Http\Exception;
use YOOtheme\Http\Exception\NotFoundException;
use YOOtheme\ImageProvider;
use YOOtheme\Translation\Translator;

return [

    'name' => 'yootheme/common',

    'main' => function ($app) {

        $app['user'] = function ($app) {
            return $app['users']->get();
        };

        $app['image'] = function ($app) {
            return new ImageProvider($app, $app['path.cache'], $app['secret']);
        };

        $app['translator'] = function ($app) {

            $translator = new Translator($app['locator']);

            if (isset($app['locale'])) {
                $translator->setLocale($app['locale']);
            }

            return $translator;
        };

    },

    'routes' => function ($route) {

        $route->get('theme/image', function ($src, $hash, $response) {

            $src = base64_decode($src);

            if ($this['image']->getHash($src) !== $hash) {
                throw new Exception(401);
            }

            if (!$image = $this['image']->create($src)) {
                throw new NotFoundException();
            }

            return $response->withFile($image->save()->getFile());
        });

    },

    'events' => [

        'init' => function ($app) {

            $app['kernel']->addMiddleware(function ($request, $response, $next) use ($app) {

                $access = (array) $request->getAttribute('access');

                foreach ($access as $permission) {
                    if (!$app['user']->hasPermission($permission)) {
                        throw new Exception(403, 'Insufficient User Rights.');
                    }
                }

                return $next($request, $response);
            });

            $app['kernel']->addMiddleware(function ($request, $response, $next) use ($app) {

                if ($request->isMethod('POST') && !$app['csrf']->validate($request->getHeaderLine('X-XSRF-Token'))) {
                    throw new Exception(401, 'Invalid CSRF token.');
                }

                return $next($request, $response);
            });

        }

    ]

];
