<?php

namespace Neokike\LaravelElasticsearchQueryBuilder\Queries\Match;

use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\InvalidArgumentException;

class ElasticMatchPhrasePrefixQuery
{
    protected $field;
    protected $value;
    /**
     * @var null
     */
    private $max_expansions;
    /**
     * @var array
     */
    private $params;

    function __construct($field, $value, $params = [])
    {
        $this->field = $field;
        $this->value = $value;
        $this->params = $params;
    }

    public function toArray()
    {
        $query = [
            'match_phrase_prefix' =>
                [
                    $this->field => [
                        'query' => $this->value,
                    ]
                ]
        ];

        if (count($this->params)) {
            foreach ($this->params as $param => $value) {
                $query['match_phrase_prefix'][$this->field][$param] = $value;
            }
        }

        return $query;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
