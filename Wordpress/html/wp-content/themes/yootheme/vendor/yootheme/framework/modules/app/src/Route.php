<?php

namespace YOOtheme;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Route
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string|callable
     */
    protected $callable;

    /**
     * @var array
     */
    protected $methods = [];

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * Constructor.
     *
     * @param string          $path
     * @param string|callable $callable
     * @param string|string[] $methods
     */
    public function __construct($path, $callable, $methods = [])
    {
        $this->setPath($path);
        $this->setMethods($methods);
        $this->callable = $callable;
    }

    /**
     * Dispatch route callable.
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        if (!$handler = $request->getAttribute('foundHandler')) {
            throw new \RuntimeException("Handler is not defined");
        }

        if ($resolver = $request->getAttribute('callableResolver')) {
            $this->callable = $resolver($this->callable);
        }

        $result = $handler($this->callable, $request, $response, $this->parameters);

        if ($result instanceof ResponseInterface) {
            $response = $result;
        } elseif (is_string($result) || (is_object($result) && method_exists($result, '__toString'))) {
            $response->write((string) $result);
        }

        return $response;
    }

    /**
     * Gets the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name.
     *
     * @param  string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = trim($name);

        return $this;
    }

    /**
     * Gets the path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the path.
     *
     * @param  string $path
     * @return self
     */
    public function setPath($path)
    {
        $this->path = '/'.trim($path, '/');

        return $this;
    }

    /**
     * Gets the callable.
     *
     * @return string|callable
     */
    public function getCallable()
    {
        return $this->callable;
    }

    /**
     * Gets the methods.
     *
     * @return string[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Sets the methods.
     *
     * @param  string|string[] $methods
     * @return self
     */
    public function setMethods($methods)
    {
        $this->methods = array_map('strtoupper', (array) $methods);

        return $this;
    }

    /**
     * Gets a parameter.
     *
     * @param  string $name
     * @param  mixed  $default
     * @return mixed
     */
    public function getParameter($name, $default = null)
    {
        return isset($this->parameters[$name]) ? $this->parameters[$name] : $default;
    }

    /**
     * Sets a parameter.
     *
     * @param  string $name
     * @param  mixed  $value
     * @return self
     */
    public function setParameter($name, $value)
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    /**
     * Gets the parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Sets the parameters.
     *
     * @param  array $parameters
     * @return self
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }
}
