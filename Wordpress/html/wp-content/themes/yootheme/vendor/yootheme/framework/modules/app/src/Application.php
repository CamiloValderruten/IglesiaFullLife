<?php

namespace YOOtheme;

use YOOtheme\Module\AutoLoader;
use YOOtheme\Module\ReplaceLoader;

class Application extends Container
{
    use EventTrait, ModuleTrait;

    /**
     * @var string
     */
    public $path = '';

    /**
     * @var boolean
     */
    public $init = false;

    /**
     * @var boolean
     */
    public $debug = false;

    /**
     * Constructor.
     *
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this['app'] = $this;

        $this['modules'] = function () {

            $kernel = new ModuleKernel($this);
            $manager = new ModuleManager($kernel, [$this]);
            $manager->register('../../../index.php', __DIR__);

            if (isset($this['autoloader'])) {
                $manager->addLoader(new AutoLoader($this['autoloader']));
            }

            return $manager;
        };

        parent::__construct($values);
    }

    /**
     * Initialize application.
     *
     * @return self
     */
    public function init()
    {
        if (!$this->init) {
            $this->init = $this->trigger('init', [$this]);
        }

        return $this;
    }

    /**
     * Run application.
     *
     * @param  boolean $send
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function run($send = true)
    {
        return $this->init()['kernel']->handle($this['request'], $this['response'], $send);
    }
}
