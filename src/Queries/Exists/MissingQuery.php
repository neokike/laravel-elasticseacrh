<?php

namespace Neokike\LaravelElasticsearchQueryBuilder\Queries\Exists;

use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\QueryInterface;

class MissingQuery implements QueryInterface
{
    protected $field;

    public function __construct($field)
    {

        $this->field = $field;
    }

    public function toArray()
    {
        $query = [
            'missing' => ['field' => $this->field]
        ];

        return $query;
    }


    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
