<?php

namespace Neokike\LaravelElasticsearch\Queries\Bool;

use Neokike\LaravelElasticsearch\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearch\Interfaces\QueryInterface;

class NotQuery
{
    /**
     * @var float
     */
    private $query;

    public function __construct($query)
    {
        $this->validateQuery($query);
        $this->query = $query;
    }

    public function toArray()
    {
        $queryArr = $this->query->toArray();
        $queryParam = reset($queryArr);
        $first_key = key($queryArr);

        $query = [
            "not" => [
                $first_key => $queryParam
            ]
        ];

        return $query;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * @param $query
     * @throws InvalidArgumentException
     */
    private function validateQuery($query)
    {
        if (!($query instanceof QueryInterface)) {
            throw new InvalidArgumentException('it must be a elasticsearch query');
        }
    }
}
