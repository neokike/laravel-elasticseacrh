<?php

namespace Neokike\LaravelElasticsearchQueryBuilder\Queries\Fuzzy;

use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\QueryInterface;

class FuzzyQuery implements QueryInterface
{
    protected $field;
    protected $value;
    protected $params;

    function __construct($field, $value, $params = [])
    {

        $this->field = $field;
        $this->value = $value;
        $this->params = $params;
    }

    public function toArray()
    {
        $query = [
            'fuzzy' =>
                [
                    $this->field => [
                        'value' => $this->value,
                    ]
                ]
        ];
        if (count($this->params)) {
            foreach ($this->params as $param => $value) {
                $query['fuzzy'][$this->field][$param] = $value;
            }
        }

        return $query;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
