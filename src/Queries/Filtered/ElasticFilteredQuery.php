<?php

namespace Neokike\LaravelElasticsearch\Queries\Filtered;

use Neokike\LaravelElasticsearch\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearch\Exceptions\NotEnoughArgumentsException;
use Neokike\LaravelElasticsearch\Interfaces\FilterInterface;
use Neokike\LaravelElasticsearch\Interfaces\QueryInterface;

class ElasticFilteredQuery
{
    protected $params;
    protected $query;
    protected $filter;


    public function __construct($params = [])
    {
        $this->params = $params;
    }

    /**
     * @param mixed $filter
     * @return ElasticFilteredQuery
     * @throws InvalidArgumentException
     */
    public function setFilter($filter)
    {
        if (!$filter instanceof FilterInterface)
            throw new InvalidArgumentException('it must be a filter object');
        $this->filter = $filter;
        return $this;
    }

    /**
     * @param mixed $query
     * @return ElasticFilteredQuery
     * @throws InvalidArgumentException
     */
    public function setQuery($query)
    {
        if (!$query instanceof QueryInterface)
            throw new InvalidArgumentException;
        $this->query = $query;
        return $this;
    }

    public function toArray()
    {
        $bool = [
            'query'  => [],
            'filter' => []
        ];

        if ($this->query) {
            array_push($bool['query'], $this->query->toArray());
        } else {
            unset($bool['query']);
        }

        if ($this->filter) {
            array_push($bool['filter'], $this->filter->toArray());
        } else {
            throw new NotEnoughArgumentsException;
        }


        $filteredQuery = [
            'filtered' => $bool
        ];

        return $filteredQuery;
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
