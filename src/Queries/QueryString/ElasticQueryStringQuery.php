<?php

namespace Neokike\LaravelElasticsearch\Queries\QueryString;

use Neokike\LaravelElasticsearch\Interfaces\QueryInterface;

class ElasticQueryStringQuery implements QueryInterface
{
    private $query;
    /**
     * @var array
     */
    private $params;

    public function __construct($query, $params = [])
    {
        $this->query = $query;
        $this->params = $params;
    }


    public function toArray()
    {
        $query = [
            'query_string' => [
                'query' => $this->query
            ]
        ];

        if (count($this->params)) {
            foreach ($this->params as $param => $value) {
                $query['query_string'][$param] = $value;
            }
        }

        return $query;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
