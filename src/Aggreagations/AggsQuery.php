<?php

namespace Neokike\LaravelElasticsearchQueryBuilder\Aggreagations;

use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\AggregatesInterface;

class AggsQuery implements AggregatesInterface
{

    private $name;
    private $agg;
    private $params;

    public function __construct($name, $agg, $params)
    {
        $this->name = $name;
        $this->agg = $agg;
        $this->params = $params;
    }

    public function toArray()
    {
        $query = [
            $this->name =>
                [
                    $this->agg => []
                ]
        ];
        if (count($this->params)) {
            $query[$this->name][$this->agg] = $this->params;
        }

        return $query;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
