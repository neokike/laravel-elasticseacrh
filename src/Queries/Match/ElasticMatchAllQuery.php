<?php

namespace Neokike\LaravelElasticsearch\Queries\Match;

use Neokike\LaravelElasticsearch\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearch\Interfaces\QueryInterface;

class ElasticMatchAllQuery implements QueryInterface
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
