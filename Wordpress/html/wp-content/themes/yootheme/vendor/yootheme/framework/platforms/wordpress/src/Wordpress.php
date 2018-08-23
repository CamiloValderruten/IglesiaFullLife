<?php

namespace YOOtheme;

use YOOtheme\Wordpress\ContentFilter;
use YOOtheme\Wordpress\Database;
use YOOtheme\Wordpress\DateHelper;
use YOOtheme\Wordpress\Option;
use YOOtheme\Wordpress\Session;
use YOOtheme\Wordpress\Update;
use YOOtheme\Wordpress\UrlGenerator;
use YOOtheme\Wordpress\UserProvider;

class Wordpress extends Module
{
    /**
     * {@inheritdoc}
     */
    public function __invoke($app)
    {
        $app->path = strtr(ABSPATH, '\\', '/');

        $app['db'] = function () {
            return new Database($GLOBALS['wpdb']);
        };

        $app['url'] = function ($app) {
            return new UrlGenerator($app['uri']);
        };

        $app['csrf'] = function () {
            return new CsrfProvider('wp_create_nonce');
        };

        $app['users'] = function () {
            return new UserProvider();
        };

        $app['date'] = function () {

            $date = new DateHelper();
            $date->setFormats([
                'medium' => get_option('date_format')
            ]);

            return $date;
        };

        $app['option'] = function () {
            return new Option('yootheme');
        };

        $app['locale'] = function () {
            return get_locale();
        };

        $app['admin'] = function () {
            return is_admin();
        };

        $app['update'] = function () {
            return new Update();
        };

        $app['session'] = function () {
            return new Session();
        };

        $app['secret'] = function () {
            return NONCE_KEY;
        };

        $app->extend('uri', function ($uri) {
            return $uri->withBasePath(get_site_url(null, '', 'relative'));
        });

        $app['events']->on('view', [$this, 'registerAssets'], -10);

        add_action('wp_footer', [$this, 'registerScriptsFooter']);
    }

    /**
     * Callback to register assets.
     */
    public function registerAssets()
    {
        wp_enqueue_script('jquery');

        $styles = '';
        $scripts = '';

        foreach ($this['styles'] as $style) {

            if ($style->getOption('defer')) {
                continue;
            }

            if ($source = $style->getSource()) {
                wp_enqueue_style($style->getName(), $this['url']->to($source, [], is_ssl()), [], $style->getOption('version') ?: false);
            } elseif ($content = $style->getContent()) {
                $styles .= sprintf("<style>%s</style>\n", $content);
            }
        }

        foreach ($this['scripts'] as $script) {

            if ($script->getOption('defer')) {
                continue;
            }

            if ($source = $script->getSource()) {
                wp_enqueue_script($script->getName(), $this['url']->to($source, [], is_ssl()), [], $script->getOption('version') ?: false);
            } elseif ($content = $script->getContent()) {
                $scripts .= sprintf("<script>%s</script>\n", $content);
            }
        }

        if ($styles) {
            add_action($this['admin'] ? 'admin_print_styles' : 'wp_head', function () use ($styles) {
                echo $styles;
            });
        }

        if ($scripts) {
            add_action($this['admin'] ? 'admin_print_scripts' : 'wp_head', function () use ($scripts) {
                echo $scripts;
            }, 30);
        }
    }

    /**
     * Callback to register scripts in footer.
     */
    public function registerScriptsFooter()
    {
        $styles = '';

        foreach ($this['styles'] as $style) {
            if ($style->getOption('defer')) {
                if ($source = $style->getSource()) {
                    $params = ($ver = $style->getOption('version')) ? ['ver' => $ver] : [];
                    $styles .= sprintf("<style>@import '%s';</style>\n", $this['url']->to($source, $params, is_ssl()));
                } elseif ($content = $style->getContent()) {
                    $styles .= sprintf("<style>%s</style>\n", $content);
                }
            }
        }

        echo $styles;

        $scripts = '';

        foreach ($this['scripts'] as $script) {
            if ($script->getOption('defer')) {
                if ($source = $script->getSource()) {
                    wp_enqueue_script($script->getName(), $this['url']->to($source, [], is_ssl()), [], $script->getOption('version') ?: false, true);
                } elseif ($content = $script->getContent()) {
                    $scripts .= sprintf("<script>%s</script>\n", $content);
                }
            }
        }

        echo $scripts;
    }
}
