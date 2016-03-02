<?php

namespace Neokike\LaravelElasticsearch;

use Neokike\LaravelElasticsearch\Exceptions\DuplicatedSearchConstraintException;
use Neokike\LaravelElasticsearch\Exceptions\InvalidMethodException;

class ElasticQueryBuilder
{
    protected $size;
    protected $aggregates;
    protected $source = true;
    protected $min_score;
    protected $from;
    protected $type;
    protected $search;
    protected $raw;

    /**
     * @param $size
     * @return $this
     */
    public function size($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @param $source
     * @return $this
     */
    public function source($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @param $score
     * @return $this
     */
    public function min_score($score)
    {
        $this->min_score = $score;

        return $this;
    }

    /**
     * @param $from
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param $type
     * @return $this
     */
    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param $search
     * @return $this
     * @throws DuplicatedSearchConstraintException
     */
    public function search($search)
    {
        $this->checkIfSearchIsDefined();
        $this->search = $search;

        return $this;
    }

    /**
     * @param $aggregates
     * @return $this
     */
    public function aggregates($aggregates)
    {
        $this->aggregates = $aggregates;

        return $this;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        if ($this->raw) {
            return $this->raw;
        }

        $query['body']['_source'] = $this->source;
        if ($this->type)
            $query['type'] = $this->type;
        if ($this->size !== false)
            $query['body']['size'] = $this->size;
        if ($this->from !== false)
            $query['body']['from'] = $this->from;
        if ($this->min_score)
            $query['body']['min_score'] = $this->min_score;

        $query['body'] = array_merge($query['body'], $this->searchArray());

        // dd(($query));
        return $query;
    }

    /**
     * @return array
     */
    public function searchArray()
    {
        $query = [];
        if ($this->search)
            $query['query'] = $this->search->toArray();

        if ($this->aggregates)
            $query['aggs'] = $this->aggregates->toArray();

        return $query;
    }

    /**
     * @return string
     */
    public function searchJson()
    {
        return json_encode($this->searchArray());
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

    /**
     * @param $method
     * @param $args
     * @return $this
     * @throws InvalidMethodException
     */
    public function __call($method, $args)
    {
        if (!method_exists($this->search, $method))
            throw new InvalidMethodException($method);

        $this->search->$method($args[0]);
        return $this;
    }

    /**
     * @throws DuplicatedSearchConstraintException
     */
    private function checkIfSearchIsDefined()
    {
        if ($this->search)
            throw new DuplicatedSearchConstraintException;
    }

    /**
     * @param mixed $raw
     * @return ElasticQueryBuilder
     */
    public function raw($raw)
    {
        $this->raw = $raw;
        return $this;
    }
}
