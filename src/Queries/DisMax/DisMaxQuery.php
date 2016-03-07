<?php

namespace Neokike\LaravelElasticsearchQueryBuilder\Queries\DisMax;

use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\QueryInterface;

class DisMaxQuery
{
    /**
     * @var float
     */
    private $boost;
    private $queries;
    /**
     * @var int
     */
    private $tieBreaker;

    public function __construct($queries, $boost = 1, $tieBreaker = 0)
    {
        $this->validateQueries($queries);
        $this->boost = $boost;
        $this->queries = $queries;
        $this->tieBreaker = $tieBreaker;
    }

    public function toArray()
    {
        $queries = [];
        foreach ($this->queries as $query) {
            array_push($queries, $query->toArray());
        }


        $query = [
            "dis_max" => [
                'queries'     => $queries,
                'boost'       => $this->boost,
                'tie_breaker' => $this->tieBreaker
            ]
        ];

        return $query;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * @param $queries
     * @throws InvalidArgumentException
     */
    private function validateQueries($queries)
    {
        if (!is_array($queries)) {
            throw new InvalidArgumentException('it must be an array of elasticsearch queries');
        }

        foreach ($queries as $query) {
            if (!($query instanceof QueryInterface)) {
                throw new InvalidArgumentException('not an elastisearch query');
            }
        }
    }
}
