<?php

namespace YOOtheme;

class Module implements \ArrayAccess
{
    use ContainerTrait;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $path;

    /**
     * @var array
     */
    public $options;

    /**
     * @var array
     */
    public $parent;

    /**
     * @var Container
     */
    public $container;

    /**
     * Constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->name = $options['name'];
        $this->path = $options['path'];
        $this->parent = $options['parent'];
        $this->options = $options;
        $this->container = new Container();
    }

    /**
     * Bootstrap callback.
     *
     * @param $app Application
     */
    public function __invoke($app)
    {
        $main = $this->options['main'];

        if ($main instanceof \Closure) {
            $main = $main->bindTo($this, $this);
        }

        if (is_callable($main)) {
            return $main($app, $this);
        }
    }
}
