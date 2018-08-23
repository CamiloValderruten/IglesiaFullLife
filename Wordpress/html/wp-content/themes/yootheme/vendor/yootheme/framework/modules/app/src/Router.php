<?php

namespace YOOtheme;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use YOOtheme\Http\Exception\NotFoundException;

class Router
{
    /**
     * @var RouteCollection
     */
    protected $routes;

    /**
     * Constructor.
     *
     * @param RouteCollection $routes
     */
    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Dispatches router for a request.
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @return ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request, ResponseInterface $response)
    {
        $path = '/'.trim($request->getQueryParam('p'), '/');

        foreach ($this->routes as $route) {

            if ($route->getMethods() && !in_array($request->getMethod(), $route->getMethods())) {
                continue;
            }

            if (preg_match($this->getPattern($route), $path, $params)) {

                foreach ($params as $key => $value) {
                    if (is_string($key)) {
                        $route->setParameter($key, urldecode($value));
                    }
                }

                return $route($request, $response);
            }
        }

        throw new NotFoundException();
    }

    /**
     * Gets the route regex pattern.
     *
     * @param  Route $route
     * @return string
     */
    protected function getPattern(Route $route)
    {
        return '#^' . preg_replace_callback('#\{(\w+)\}#', function ($matches) {
            return '(?P<' . $matches[1] . '>[^/]+)';
        }, $route->getPath()) . '$#';
    }
}
