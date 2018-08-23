<?php

namespace YOOtheme\Http;

class Request extends Message\ServerRequest
{
    use Message;

    /**
     * Does this request use a given method?
     *
     * @param  string $method
     * @return bool
     */
    public function isMethod($method)
    {
        return $this->getMethod() === strtoupper($method);
    }

    /**
     * Sets an array of attributes on the instance.
     *
     * @param  array $attributes
     * @return self
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Sets a attribute value on the instance.
     *
     * @param  string $name
     * @param  mixed  $value
     * @return self
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Retrieve a parameter value from body or query string (in that order).
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    public function getParam($key, $default = null)
    {
        $body = $this->getParsedBody();

        if (is_array($body) && isset($body[$key])) {
            return $body[$key];
        }

        if (is_object($body) && property_exists($body, $key)) {
            return $body->$key;
        }

        return $this->getQueryParam($key, $default);
    }

    /**
     * Retrieve an array of body and query string parameters.
     *
     * @return array
     */
    public function getParams()
    {
        $params = $this->getQueryParams();

        if ($body = $this->getParsedBody()) {
            $params = array_merge($params, (array) $body);
        }

        return $params;
    }

    /**
     * Retrieve a value from query string parameters.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    public function getQueryParam($key, $default = null)
    {
        $query = $this->getQueryParams();

        return isset($query[$key]) ? $query[$key] : $default;
    }

    /**
     * Retrieve a value from server parameters.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    public function getServerParam($key, $default = null)
    {
        $server = $this->getServerParams();

        return isset($server[$key]) ? $server[$key] : $default;
    }

    /**
     * Retrieve a single file upload.
     *
     * @param  string $key
     * @return UploadedFileInterface
     */
    public function getUploadedFile($key)
    {
        $files = $this->getUploadedFiles();

        return isset($files[$key]) ? $files[$key] : null;
    }
}
