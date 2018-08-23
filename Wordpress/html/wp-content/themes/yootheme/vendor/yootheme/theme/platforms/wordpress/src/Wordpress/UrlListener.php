<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\EventSubscriber;

class UrlListener extends EventSubscriber
{
    const REGEX_URL = '/
                        \s                              # match a space
                        (?<attr>href|src|poster)=       # match the attribute
                        ([\"\'])                        # start with a single or double quote
                        (?!\/|\#|[a-z0-9\-\.]+\:)       # make sure it is a relative path
                        (?<url>[^\"\'>]+)               # match the actual src value
                        \2                              # match the previous quote
                       /xiU';

    public function onSite($theme)
    {
        $theme['view']->addLoader($this);
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke($name, $parameters, $next)
    {
        if (!is_string($content = $next($name, $parameters))) {
            return $content;
        }

        return preg_replace_callback(self::REGEX_URL, function ($matches) {
            return sprintf(' %s="%s"', $matches['attr'], $this['url']->to($matches['url']));
        }, $content);

    }

    public static function getSubscribedEvents()
    {
        return [
            'theme.site' => 'onSite',
        ];
    }
}
