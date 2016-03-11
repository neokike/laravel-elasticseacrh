<?php

namespace Neokike\LaravelElasticsearchQueryBuilder\Queries\Match;

use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\QueryInterface;

class MatchAllQuery implements QueryInterface
{
    /**
     * @var float
     */
    private $boost;
    /**
     * @var array
     */
    private $params;

    public function __construct($params = [])
    {
        $this->params = $params;
    }

    public function toArray()
    {
        $query = [
            "match_all" => []
        ];

        if (count($this->params)) {
            foreach ($this->params as $param => $value) {
                $query['match_all'][$param] = $value;
            }
        }

        return $query;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
