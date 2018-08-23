<?php

namespace YOOtheme\Http;

use YOOtheme\Http\Message\Stream;
use YOOtheme\Util\Arr;

class Response extends Message\Response
{
    use Message;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * Retrieve an array of attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
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
     * Retrieve a attribute value.
     *
     * @param  string $name
     * @param  string $default
     * @return mixed
     */
    public function getAttribute($name, $default = null)
    {
        return Arr::get($this->attributes, $name, $default);
    }

    /**
     * Sets a attribute value on the instance.
     *
     * @param  string $name
     * @param  mixed $value
     * @return self
     */
    public function setAttribute($name, $value)
    {
        Arr::set($this->attributes, $name, $value);

        return $this;
    }

    /**
     * Writes data to the body.
     *
     * @param  string $data
     * @return self
     */
    public function write($data)
    {
        $body = $this->getBody();
        $body->write($data);

        return $this;
    }

    /**
     * Writes a file to body.
     *
     * @param  string $file
     * @throws \InvalidArgumentException
     * @return self
     */
    public function withFile($file)
    {
        if (!is_file($file)) {
            throw new \InvalidArgumentException('Invalid file');
        }

        $body = new Stream($file);

        if (is_callable('finfo_file')) {
            $type = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file);
        } elseif (is_callable('mime_content_type')) {
            $type = mime_content_type($file);
        }

        return $this->withBody($body)->withHeader('Content-Type', $type)->withHeader('Content-Length', $body->getSize());
    }

    /**
     * Writes JSON to the body.
     *
     * @param  mixed  $data
     * @param  int    $status
     * @param  int    $options
     * @throws \InvalidArgumentException
     * @return self
     */
    public function withJson($data, $status = null, $options = 0)
    {
        $response = $this->withBody(new Stream)->write($json = @json_encode($data, $options));

        if ($json === false) {
            $message = is_callable('json_last_error_msg') ? json_last_error_msg() : '';
            throw new \InvalidArgumentException($message ?: 'Invalid JSON', json_last_error());
        }

        if (isset($status)) {
            $response = $response->withStatus($status);
        }

        return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * Redirect response.
     *
     * @param  string $url
     * @param  int    $status
     * @return self
     */
    public function withRedirect($url, $status = 302)
    {
        return $this->withStatus($status)->withHeader('Location', (string) $url);
    }

    /**
     * Sends the response.
     *
     * @return self
     */
    public function send()
    {
        if (!headers_sent()) {

            header(sprintf('HTTP/%s %s %s',
                $this->getProtocolVersion(),
                $this->getStatusCode(),
                $this->getReasonPhrase()
            ));

            foreach ($this->getHeaders() as $name => $values) {
                foreach ($values as $value) {
                    header(sprintf('%s: %s', $name, $value), false);
                }
            }
        }

        echo $this->getBody();

        if ('cli' !== PHP_SAPI) {
            flush();
        }

        return $this;
    }

    /**
     * Returns the body as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getBody();
    }
}
