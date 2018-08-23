<?php

use YOOtheme\Theme\CacheController;

return [

    'name' => 'yootheme/settings',

    'main' => function ($app) {

        $app['#cache'] = function () {
            return new CacheController($this);
        };

    },

    'events' => [

        'theme.init' => function ($theme) {

            // set defaults
            $theme->merge($this->options['config']['defaults'], true);
        },

        'theme.admin' => function ($theme) {

            // add script
            $this['scripts']->add('customizer-settings', "{$this->path}/app/settings.min.js", 'customizer');
        },

        'theme.site' => [function ($theme) {

            // set config
            $theme->merge([
                'body_class' => [$theme->get('page_class')],
                'favicon' => $this['url']->to($theme->get('favicon') ?: '@assets/images/favicon.png'),
                'touchicon' => $this['url']->to($theme->get('touchicon') ?: '@assets/images/apple-touch-icon.png'),
            ]);

            // combine assets
            if ($theme->get('compression') && !$theme['@customizer']->isActive()) {
                $this['styles']->combine('styles', 'theme-*', ['CssImportResolver', 'CssRewriteUrl']);
                $this['scripts']->combine('scripts', '{theme-*,uikit*}');
            }

            // google analytics
            if ($id = $theme->get('google_analytics')) {
                $this['scripts']
                    ->add('google-analytics', 'https://www.google-analytics.com/analytics.js', [], ['defer' => true])
                    ->add('google-analytics-id', "window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)}; ga.l=+new Date; ga('create','{$id}','auto'); ga('send','pageview');", [], 'string');
            }

        }, 5]

    ],

    'routes' => function ($route) {

        $route->get('/cache', '#cache:index');
        $route->post('/cache/clear', '#cache:clear');

    },

    'config' => [

        'section' => [
            'title' => 'Settings',
            'priority' => 60
        ],

        'fields' => [],

        'defaults' => []

    ]

];
