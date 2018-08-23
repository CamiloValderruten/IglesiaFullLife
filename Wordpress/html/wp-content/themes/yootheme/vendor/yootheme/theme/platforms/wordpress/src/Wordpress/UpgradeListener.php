<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\EventSubscriber;

class UpgradeListener extends EventSubscriber
{
    public function onInit($theme)
    {
        if (!$this['admin']) {
            return;
        }

        add_action('wp_loaded', function () use ($theme) {
            $this['update']->register(basename($theme->path), 'theme', $theme->options['update'], ['key' => $theme->get('yootheme_apikey')]);
        }, 15);

        add_filter('upgrader_pre_install', function ($return, $package) use ($theme) {

            if (!is_wp_error($return)) {
                $this->move($theme, $package);
            }

            return $return;

        }, 10, 2);

        add_filter('upgrader_post_install', function ($return, $package) use ($theme) {

            if (!is_wp_error($return)) {
                $this->move($theme, $package, true);
            }

            return $return;

        }, 10, 2);
    }

    public function move($theme, $package, $reverse = false)
    {
        global $wp_filesystem;

        $name = isset($package['theme']) ? $package['theme'] : '';
        $content = $wp_filesystem->wp_content_dir();

        if ($name != basename($theme->path)) {
            return;
        }

        foreach (['theme.css', 'theme.rtl.css'] as $file) {

            $paths = [
                "{$theme->path}/css/{$file}",
                "{$content}/upgrade/{$name}_{$file}",
            ];

            if ($reverse) {
                $paths = array_reverse($paths);
            }

            if ($wp_filesystem->exists($paths[0])) {
                $wp_filesystem->move($paths[0], $paths[1], true);
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'theme.init' => 'onInit'
        ];
    }
}
