<?php

$config = [

    'name' => 'yootheme/wordpress',

    'main' => 'YOOtheme\\Wordpress',

    'events' => [

        'init' => function ($app) {

            if (isset($this['path.cache']) && !is_dir($this['path.cache']) && !mkdir($this['path.cache'], 0777, true)) {
                throw new \RuntimeException(sprintf('Unable to create cache folder in "%s"', $this['path.cache']));
            }

            add_action($this['admin'] ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts', function () use ($app) {
                $this['events']->trigger('view', [$app]);
            });

            add_filter('the_content', function ($content) {

                $this['events']->trigger('content', [$content]);

                return $content;
            });

            $handle = function () use ($app) {
                $app->run();
                exit;
            };

            add_action('wp_ajax_kernel', $handle);
            add_action('wp_ajax_nopriv_kernel', $handle);
        }

    ]

];

return defined('WPINC') ? $config : false;
