<?php

namespace YOOtheme;

trait ContainerTrait
{
    /**
     * Checks if a parameter or an object is set.
     *
     * @param  string $name
     * @return mixed
     */
    public function offsetExists($name)
    {
        if (!isset($this->container[$name])) {
            return isset($this->parent[$name]);
        }

        return true;
    }

    /**
     * Gets a parameter or an object.
     *
     * @param  string $name
     * @return mixed
     */
    public function offsetGet($name)
    {
        if (!isset($this->container[$name]) && isset($this->parent)) {
            return $this->parent[$name];
        }

        return $this->container[$name];
    }

    /**
     * Sets a parameter or an object.
     *
     * @param  string $name
     * @param  mixed  $value
     */
    public function offsetSet($name, $value)
    {
        $this->container[$name] = $value;
    }

    /**
     * Unsets a parameter or an object.
     *
     * @param string $name
     */
    public function offsetUnset($name)
    {
        unset($this->container[$name]);
    }
}
