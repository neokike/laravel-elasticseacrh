<?php

namespace Neokike\LaravelElasticsearch\Queries\Exists;

use Neokike\LaravelElasticsearch\Interfaces\QueryInterface;

class ExistsQuery implements QueryInterface
{
    protected $field;

    public function __construct($field)
    {

        $this->field = $field;
    }

    public function toArray()
    {
        $query = [
            'exists' => ['field' => $this->field]
        ];

        return $query;
    }


    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
