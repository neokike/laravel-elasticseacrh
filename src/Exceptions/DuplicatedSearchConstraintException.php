<?php
namespace Neokike\LaravelElasticsearch\Exceptions;

use Exception;

class DuplicatedSearchConstraintException extends Exception
{

    public function __construct($message = 'the search constraint have been defined', $code = 0, Exception $previous = null)
    {

        parent::__construct($message, $code, $previous);
    }

}