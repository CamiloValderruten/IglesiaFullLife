<?php

namespace YOOtheme;

use YOOtheme\Util\Collection;
use YOOtheme\Util\MethodTrait;

class Theme extends Module
{
    use MethodTrait;

    /**
     * {@inheritdoc}
     */
    public function __invoke($app)
    {
        $app['theme'] = $this;

        $app['view']
            ->addGlobal('theme', $this)
            ->addLoader([$this, 'replace']);

        $app['locator']
            ->addPath($this->path, 'theme')
            ->addPath($this->path, 'assets')
            ->addPath("{$this->path}/templates", 'views');
    }

    /**
     * Gets a config value.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $value = $this['@config']->get($key, $default);

        return is_array($value) ? new Collection($value) : $value;
    }

    /**
     * Sets a config value.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return self
     */
    public function set($key, $value)
    {
        $this['@config']->set($key, $value);

        return $this;
    }

    /**
     * Merges an array of config values.
     *
     * @param  mixed $items
     * @param  bool  $recursive
     * @return self
     */
    public function merge($items, $recursive = false)
    {
        $this['@config']->merge($items, $recursive);

        return $this;
    }

    /**
     * Renders a template.
     *
     * @param  string $name
     * @param  mixed  $parameters
     * @return string|false
     */
    public function render($name, $parameters = [])
    {
        return $this['view']->render($name, $parameters);
    }

    /**
     * Replaces images URLs.
     *
     * @param  string   $name
     * @param  mixed    $parameters
     * @param  callable $next
     * @return string
     */
    public function replace($name, $parameters, $next)
    {
        return $this['image']->replace($next($name, $parameters));
    }
}
