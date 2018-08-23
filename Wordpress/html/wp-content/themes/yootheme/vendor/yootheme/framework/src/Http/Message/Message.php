<?php

namespace YOOtheme\Http\Message;

use Psr\Http\Message\StreamInterface;

abstract class Message
{
    /**
     * @var StreamInterface
     */
    protected $body;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var string
     */
    protected $version = '1.1';

    /**
     * {@inheritdoc}
     */
    public function getProtocolVersion()
    {
        return $this->version;
    }

    /**
     * {@inheritdoc}
     */
    public function withProtocolVersion($version)
    {
        if (!preg_match('/^[1-9]\d*(?:\.\d)?$/', $version)) {
            throw new \InvalidArgumentException(sprintf('Invalid HTTP version. (%s)', $version));
        }

        $clone = clone $this;
        $clone->version = $version;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function withBody(StreamInterface $body)
    {
        $clone = clone $this;
        $clone->body = $body;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * {@inheritdoc}
     */
    public function hasHeader($name)
    {
        return isset($this->headers[strtolower($name)]);
    }

    /**
     * {@inheritdoc}
     */
    public function getHeader($name)
    {
        return $this->hasHeader($name) ? $this->headers[strtolower($name)] : [];
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaderLine($name)
    {
        return implode(',', $this->getHeader($name));
    }

    /**
     * {@inheritdoc}
     */
    public function withHeader($name, $value)
    {
        $clone = clone $this;
        $clone->headers[strtolower($name)] = (array) $value;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function withAddedHeader($name, $value)
    {
        if (!$this->hasHeader($name)) {
            return $this->withHeader($name, $value);
        }

        $clone = clone $this;
        $clone->headers[strtolower($name)][] = $value;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutHeader($name)
    {
        if (!$this->hasHeader($name)) {
            return $this;
        }

        $clone = clone $this;
        unset($clone->headers[strtolower($name)]);

        return $clone;
    }

    /**
     * Normalizes the headers.
     *
     * @param  array $headers
     * @return array
     */
    protected static function normalizeHeaders(array $headers)
    {
        $normalized = [];

        foreach ($headers as $name => $value) {
            $normalized[strtr(strtolower($name), '_', '-')] = (array) $value;
        }

        return $normalized;
    }
}
