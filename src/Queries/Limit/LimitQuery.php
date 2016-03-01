<?php

namespace Neokike\LaravelElasticsearch\Queries\Limit;

class LimitQuery
{
    private $value;

    public function __construct($value)
    {

        $this->value = $value;
    }

    public function toArray()
    {
        $query = [
            "limit" => [
                'value' => $this->value
            ]
        ];

        return $query;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
