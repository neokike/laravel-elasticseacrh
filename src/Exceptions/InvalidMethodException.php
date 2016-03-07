<?php
namespace Neokike\LaravelElasticsearchQueryBuilder\Exceptions;

use Exception;

class InvalidMethodException extends Exception
{

    public function __construct($method = '', $message = 'method is not accepted', $code = 0, Exception $previous = null)
    {

        $message = $method . ' ' . $message;
        parent::__construct($message, $code, $previous);
    }

}