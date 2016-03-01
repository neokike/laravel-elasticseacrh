<?php

namespace Neokike\LaravelElasticsearch\Queries\ConstantScore;

use Neokike\LaravelElasticsearch\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearch\Interfaces\QueryInterface;

class ConstantScoreQuery implements QueryInterface
{
    /**
     * @var float
     */
    private $boost;
    private $query;

    public function __construct($query, $boost)
    {
        $this->validateQuery($query);
        $this->boost = $boost;
        $this->query = $query;
    }

    public function toArray()
    {
        $queryArr = $this->query->toArray();
        $queryParam = reset($queryArr);
        $first_key = key($queryArr);

        $query = [
            "constant_score" => [
                $first_key => $queryParam,
                'boost'    => $this->boost
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
