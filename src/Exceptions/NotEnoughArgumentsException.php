<?php
namespace Neokike\LaravelElasticsearch\Exceptions;

use Exception;

class NotEnoughArgumentsException extends Exception
{

    public function __construct($message = 'You have to define one or more options', $code = 0, Exception $previous = null)
    {

        parent::__construct($message, $code, $previous);
    }

}