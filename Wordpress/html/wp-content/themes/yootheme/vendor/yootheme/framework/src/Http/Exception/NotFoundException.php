<?php

namespace YOOtheme\Http\Exception;

use YOOtheme\Http\Exception as HttpException;

class NotFoundException extends HttpException
{
    /**
     * Constructor
     *
     * @param string     $message
     * @param \Exception $previous
     */
    public function __construct($message = '', \Exception $previous = null)
    {
        parent::__construct(404, $message, $previous);
    }
}
