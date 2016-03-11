<?php

namespace Neokike\LaravelElasticsearchQueryBuilder\Queries\Match;

use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\QueryInterface;

class MatchPhraseQuery implements QueryInterface
{
    protected $field;
    protected $value;
    /**
     * @var null
     */
    private $analyzer;
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
            'match_phrase' =>
                [
                    $this->field => [
                        'query' => $this->value,
                    ]
                ]
        ];

        if (count($this->params)) {
            foreach ($this->params as $param => $value) {
                $query['match_phrase'][$this->field][$param] = $value;
            }
        }
        return $query;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
