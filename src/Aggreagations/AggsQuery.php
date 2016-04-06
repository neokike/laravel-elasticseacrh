<?php

namespace Neokike\LaravelElasticsearchQueryBuilder\Aggreagations;

use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\AggregatesInterface;

class AggsQuery implements AggregatesInterface
{

    private $name;
    private $agg;
    private $aggParams;
    /**
     * @var null
     */
    private $aggs;

    public function __construct($name, $agg, $aggParams, $aggs = null)
    {
        $this->name = $name;
        $this->agg = $agg;
        $this->aggParams = $aggParams;
        $this->aggs = $aggs;
    }

    public function toArray()
    {
        $query = [
            $this->name =>
                [
                    $this->agg => []
                ]
        ];
        if (count($this->aggParams)) {
            $query[$this->name][$this->agg] = $this->aggParams;
        }

        if ($this->aggs) {
            $query[$this->name]['aggs'] = $this->aggs->toArray();
        }

        return $query;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
