<?php

namespace YOOtheme;

abstract class EventSubscriber implements EventSubscriberInterface, \ArrayAccess
{
    use ContainerTrait;

    /**
     * @var \ArrayAccess
     */
    protected $container;

    /**
     * Constructor.
     *
     * @param \ArrayAccess $container
     */
    public function __construct(\ArrayAccess $container = null)
    {
        $this->container = $container;
    }
}
