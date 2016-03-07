<?php

namespace Neokike\LaravelElasticsearchQueryBuilder\Queries\Common;

use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\QueryInterface;

class ElasticCommonTermsQuery implements QueryInterface
{
    protected $params;
    private $query;

    public function __construct($query, $params = [])
    {
        $this->params = $params;
        $this->query = $query;
    }


    public function toArray()
    {
        $query = [
            'common' =>
                [
                    'body' => [
                        'query' => $this->query,
                    ]
                ]
        ];
        if (count($this->params)) {
            foreach ($this->params as $param => $value) {
                $query['common']['body'][$param] = $value;
            }
        }

        return $query;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
