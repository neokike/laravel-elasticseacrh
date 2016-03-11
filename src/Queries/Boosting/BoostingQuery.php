<?php

namespace Neokike\LaravelElasticsearchQueryBuilder\Queries\Boosting;

use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\DuplicatedSearchConstraintException;
use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\NotEnoughArgumentsException;
use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\QueryInterface;

class BoostingQuery implements QueryInterface
{
    protected $positive;
    protected $negative;
    /**
     * @var null
     */
    private $negative_boost;

    public function __construct($negative_boost)
    {
        if (!is_float($negative_boost))
            throw new InvalidArgumentException('the negative boost must be a float value');

        $this->negative_boost = $negative_boost;
    }

    public function setPositive($query)
    {
        if (!$query instanceof QueryInterface)
            throw new InvalidArgumentException;

        if ($this->positive)
            throw new DuplicatedSearchConstraintException('positive condition have been already defined');

        $this->positive = $query;

        return $this;
    }

    public function setNegative($query)
    {
        if (!$query instanceof QueryInterface)
            throw new InvalidArgumentException;

        if ($this->negative)
            throw new DuplicatedSearchConstraintException('negative condition have been already defined');

        $this->negative = $query;

        return $this;
    }

    public function toArray()
    {
        if (!$this->positive || !$this->negative || !$this->negative_boost)
            throw new NotEnoughArgumentsException('You have to define positive, negative and negative boost in the boosting query');

        return [
            'boosting' => [
                'positive'       => $this->positive->toArray(),
                'negative'       => $this->negative->toArray(),
                'negative_boost' => $this->negative_boost
            ]
        ];
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * get property value
     * @param $propertyName
     * @return $this->$propertyName || null
     */
    public function __get($propertyName)
    {
        if (property_exists($this, $propertyName)) {
            return $this->$propertyName;
        }

        return null;
    }
}
