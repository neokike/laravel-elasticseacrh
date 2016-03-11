<?php

namespace Neokike\LaravelElasticsearchQueryBuilder\Queries\Match;

use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\QueryInterface;

class MultiMatchQuery extends MatchQuery implements QueryInterface
{

    private $acceptedTypes = ['best_fields', 'most_fields', 'cross_fields', 'phrase', 'phrase_prefix'];
    /**
     * @var
     */
    protected $type;
    /**
     * @var array
     */
    private $fields;
    /**
     * @var null
     */
    private $tie_breaker;


    function __construct($fields, $value, $type = 'best_fields', $tie_breaker = null, $params = [])
    {

        if (!in_array($type, $this->acceptedTypes))
            throw new InvalidArgumentException('the type must be best_fields, most_fields, cross_fields, phrase, phrase_prefix');

        if (!is_array($fields))
            throw new InvalidArgumentException('the fields must be an array of fields');

        if (!is_float($tie_breaker) && $tie_breaker != null)
            throw new InvalidArgumentException('the tie_breaker must be a float value');

        parent::__construct($fields, $value, $params);
        $this->type = $type;
        $this->fields = $fields;
        $this->tie_breaker = $tie_breaker;
    }

    public function toArray()
    {
        $query = [
            'multi_match' =>
                [
                    'query'  => $this->value,
                    'type'   => $this->type,
                    'fields' => $this->fields,
                ]
        ];

        if ($this->tie_breaker) {
            $query['multi_match']['tie_breaker'] = $this->tie_breaker;
        }

        if (count($this->params)) {
            foreach ($this->params as $param => $value) {
                $query['multi_match'][$param] = $value;
            }
        }

        return $query;
    }
}
