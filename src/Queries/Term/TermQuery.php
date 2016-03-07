<?php

namespace Neokike\LaravelElasticsearchQueryBuilder\Queries\Term;

use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\QueryInterface;

class TermQuery implements QueryInterface
{

    private $field;
    private $search;
    /**
     * @var array
     */
    private $params;

    public function __construct($field, $search, $params = [])
    {

        $this->field = $field;
        $this->search = $search;
        $this->params = $params;
    }

    public function toArray()
    {
        if (count($this->params)) {
            $query = [
                'term' => [
                    $this->field => [
                        'value' => $this->search
                    ]
                ]
            ];

            foreach ($this->params as $param => $value) {
                $query['term'][$this->field][$param] = $value;
            }

            return $query;
        }

        $query = [
            'term' => [$this->field => $this->search]
        ];

        return $query;
    }


    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
