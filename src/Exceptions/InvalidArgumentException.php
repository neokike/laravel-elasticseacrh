<?php
namespace Neokike\LaravelElasticsearchQueryBuilder\Exceptions;

use Exception;

class InvalidArgumentException extends Exception
{

    public function __construct($message = 'it must be a query object', $code = 0, Exception $previous = null)
    {

        parent::__construct($message, $code, $previous);
    }

}