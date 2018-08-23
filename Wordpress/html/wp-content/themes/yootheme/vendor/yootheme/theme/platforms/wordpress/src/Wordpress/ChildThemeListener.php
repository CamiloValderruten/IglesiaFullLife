<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\EventSubscriber;

class ChildThemeListener extends EventSubscriber
{
    public function init($app)
    {
        if (!is_child_theme()) {
            return;
        }

        $path = get_stylesheet_directory();

        $this['locator']
            ->addPath($path, 'theme')
            ->addPath($path, 'assets')
            ->addPath("{$path}/templates", 'views')
            ->addPath("{$path}/builder", 'builder');
    }

    public static function getSubscribedEvents()
    {
        return [
            'init' => 'init'
        ];
    }
}
