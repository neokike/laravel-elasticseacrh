<?php

namespace Neokike\LaravelElasticsearch\Queries\Type;

use Neokike\LaravelElasticsearch\Interfaces\QueryInterface;

class TypeQuery implements QueryInterface
{
    private $type;

    public function __construct($type)
    {

        $this->type = $type;
    }

    public function toArray()
    {
        $query = [
            "type" => [
                'value' => $this->type
            ]
        ];

        return $query;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
