<?php

namespace YOOtheme\Http\Exception;

use YOOtheme\Http\Exception as HttpException;

class MethodNotAllowedException extends HttpException
{
    /**
     * @var array
     */
    protected $allowed;

    /**
     * Constructor
     *
     * @param array      $allowed
     * @param string     $message
     * @param \Exception $previous
     */
    public function __construct(array $allowed = [], $message = '', \Exception $previous = null)
    {
        parent::__construct(405, $message, $previous);

        $this->allowed = $allowed;
    }

    /**
     * Gets the allowed methods.
     *
     * @return array
     */
    public function getAllowed()
    {
        return $this->allowed;
    }
}
