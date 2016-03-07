<?php

namespace Neokike\LaravelElasticsearchQueryBuilder\Queries\Bool;

use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\NotEnoughArgumentsException;
use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\FilterInterface;
use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\QueryInterface;

class ElasticBoolQuery implements QueryInterface
{
    protected $must = [];
    protected $mustNot = [];
    protected $should = [];
    protected $minimum_should_match = null;
    protected $boost = null;
    protected $filter = [];
    /**
     * @var
     */
    private $params;

    public function __construct($params = [])
    {

        $this->params = $params;
    }

    public function setMust($query)
    {
        if (!$query instanceof QueryInterface)
            throw new InvalidArgumentException;
        array_push($this->must, $query);

        return $this;
    }

    public function setMustNot($query)
    {
        if (!$query instanceof QueryInterface)
            throw new InvalidArgumentException;
        array_push($this->mustNot, $query);

        return $this;
    }

    public function setShould($query)
    {
        if (!$query instanceof QueryInterface)
            throw new InvalidArgumentException;
        array_push($this->should, $query);

        return $this;
    }

    public function toArray()
    {
        $bool = [
            'must'     => [],
            'must_not' => [],
            'should'   => [],
            'filter'   => []
        ];

        if (count($this->must)) {
            foreach ($this->must as $must) {
                array_push($bool['must'], $must->toArray());
            }
        } else {
            unset($bool['must']);
        }

        if (count($this->mustNot)) {
            foreach ($this->mustNot as $mustNot) {
                array_push($bool['must_not'], $mustNot->toArray());
            }
        } else {
            unset($bool['must_not']);
        }

        if (count($this->should)) {
            foreach ($this->should as $should) {
                array_push($bool['should'], $should->toArray());
            }
        } else {
            unset($bool['should']);
        }

        if (count($this->filter)) {
            foreach ($this->filter as $filter) {
                array_push($bool['filter'], $filter->toArray());
            }
        } else {
            unset($bool['filter']);
        }


        if (!count($bool))
            throw new NotEnoughArgumentsException;

        if ($this->minimum_should_match) {
            $bool['minimum_should_match'] = $this->minimum_should_match;
        }

        if ($this->boost) {
            $bool['boost'] = $this->boost;
        }

        if (count($this->params)) {
            foreach ($this->params as $param => $value) {
                $bool[$param] = $value;
            }
        }

        $boolQuery = [
            'bool' => $bool
        ];


        return $boolQuery;
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

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function setMinimunShouldMatch($minimum_should_match)
    {
        if (!is_int($minimum_should_match))
            throw new InvalidArgumentException('it must be an integer');
        $this->minimum_should_match = $minimum_should_match;

        return $this;
    }

    public function setBoost($boost)
    {
        if (!is_float($boost) && !is_int($boost))
            throw new InvalidArgumentException('it must be an integer');
        $this->boost = $boost;

        return $this;
    }

    public function setFilter($filter)
    {
        if (!$filter instanceof FilterInterface)
            throw new InvalidArgumentException('it must be a filter object');
        array_push($this->filter, $filter);

        return $this;
    }

}
