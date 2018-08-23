<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\EventSubscriber;
use YOOtheme\Theme\Customizer;

class CustomizerListener extends EventSubscriber
{
    public $active = false;

    public function onInit($theme)
    {
        $this['@customizer'] = function () {
            return new Customizer($this->active);
        };

        $theme['@customizer'] = function () {
            return $this['@customizer'];
        };

        add_action('customize_register', function ($customizer) use ($theme) {

            // set active
            $this->active = true;

            // add settings
            $customizer->add_setting('config');
            $customizer->add_setting('page');
            $customizer->add_setting('uikit_dev');
            $customizer->remove_setting('site_icon');

            // encode config
            add_filter('customize_sanitize_js_config', function ($value) use ($theme) {
                return base64_encode($theme['@config']->json());
            });

            // decode config
            add_filter('customize_sanitize_config', function ($value) {
                return base64_decode($value);
            });

            // remove page
            add_action('customize_save', function ($customizer) {
                $customizer->remove_setting('page');
                $customizer->remove_setting('uikit_dev');
            });

        }, 10);
    }

    public function onSite($theme)
    {
        // is active?
        if (!$this->isActive()) {
            return;
        }

        // add assets
        $this['styles']->add('customizer', 'platforms/wordpress/assets/css/site.css');
    }

    public function onAdmin($theme)
    {
        // add assets
        $this['styles']->add('customizer', 'platforms/wordpress/assets/css/admin.css');
        $this['scripts']->add('customizer', 'platforms/wordpress/app/customizer.min.js', ['uikit', 'vue']);
    }

    public function onView($event)
    {
        // add data
        if ($this['@customizer']->isActive() && $data = $this['@customizer']->getData()) {
            $this['scripts']->add('customizer-data', sprintf('var $customizer = %s;', json_encode($data)), 'customizer', 'string');
        }
    }

    public function isActive()
    {
        return isset($this['@customizer']) && $this['@customizer']->isActive();
    }

    public static function getSubscribedEvents()
    {
        return [
            'theme.init' => ['onInit', 10],
            'theme.site' => ['onSite', 15],
            'theme.admin' => 'onAdmin',
            'view' => 'onView'
        ];
    }
}
