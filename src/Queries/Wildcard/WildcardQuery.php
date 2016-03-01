<?php

namespace Neokike\LaravelElasticsearch\Queries\Wildcard;

use Neokike\LaravelElasticsearch\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearch\Interfaces\QueryInterface;

class WildcardQuery implements QueryInterface
{
    private $field;
    private $search;
    /**
     * @var array
     */
    private $params;

    public function __construct($field, $search, $params = [])
    {
        $this->validateSearch($search);
        $this->field = $field;
        $this->search = $search;
        $this->params = $params;
    }

    public function toArray()
    {
        if (count($this->params)) {
            $query = [
                'wildcard' => [
                    $this->field => [
                        'value' => $this->search
                    ]
                ]
            ];

            foreach ($this->params as $param => $value) {
                $query['wildcard'][$this->field][$param] = $value;
            }

            return $query;
        }

        $query = [
            'wildcard' => [$this->field => $this->search]
        ];

        return $query;
    }


    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * @param $search
     * @throws InvalidArgumentException
     */
    private function validateSearch($search)
    {
        if (strpos($search,'*') === false && strpos($search,'?') === false)
            throw new InvalidArgumentException('it must have a wildcard item (* or ?)');
    }
}
