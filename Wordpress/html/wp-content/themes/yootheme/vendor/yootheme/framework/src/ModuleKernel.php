<?php

namespace YOOtheme;

class ModuleKernel
{
    /**
     * @var array
     */
    protected $defaults = [
        'main' => null,
        'type' => 'module',
        'class' => 'YOOtheme\Module',
        'config' => []
    ];

    /**
     * Constructor.
     *
     * @param Application $app
     */
    public function __construct($app)
    {
        $this->defaults['parent'] = $app;
    }

    /**
     * Loader callback.
     *
     * @param  array $options
     * @return mixed
     */
    public function __invoke(array $options)
    {
        $options = array_replace($this->defaults, $options);
        $class = $options[is_string($options['main']) ? 'main' : 'class'];

        return new $class($options);
    }
}
