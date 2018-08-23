<?php

namespace YOOtheme\Http\Exception;

use YOOtheme\Http\Exception as HttpException;

class BadRequestException extends HttpException
{
    /**
     * Constructor
     *
     * @param string     $message
     * @param \Exception $previous
     */
    public function __construct($message = '', \Exception $previous = null)
    {
        parent::__construct(400, $message, $previous);
    }
}
