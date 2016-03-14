<?php

namespace Neokike\LaravelElasticsearchQueryBuilder;

use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\DuplicatedSearchConstraintException;
use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\InvalidMethodException;
use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\AggregatesInterface;

class ElasticQueryBuilder
{
    protected $size;
    protected $index;
    protected $aggregates;
    protected $source = true;
    protected $min_score;
    protected $from;
    protected $type;
    protected $sort = [];
    protected $raw;
    protected $query;
    protected $explain;
    protected $version;

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
    public function query($search)
    {
        $this->checkIfSearchIsDefined();
        $this->query = $search;

        return $this;
    }

    /**
     * @param $aggregates
     * @return $this
     */
    public function aggregates(AggregatesInterface $aggregates)
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
        if ($this->index)
            $query['index'] = $this->index;
        if ($this->type)
            $query['type'] = $this->type;
        if ($this->size !== false)
            $query['body']['size'] = $this->size;
        if ($this->from !== false)
            $query['body']['from'] = $this->from;
        if ($this->min_score)
            $query['body']['min_score'] = $this->min_score;
        if ($this->explain)
            $query['body']['explain'] = $this->explain;
        if ($this->version)
            $query['body']['version'] = $this->version;
        $query['body'] = array_merge($query['body'], $this->searchArray());
        if (count($this->sort)) {
            foreach ($this->sort as $sort) {
                $sortArray[] = $sort->toArray();
            }
            $query['body']['sort'] = $sortArray;
        }

        // dd(($query));
        return $query;
    }

    /**
     * @return array
     */
    public function searchArray()
    {
        $query = [];
        if ($this->query)
            $query['query'] = $this->query->toArray();

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
        if (!method_exists($this->query, $method))
            throw new InvalidMethodException($method);

        $this->query->$method($args[0]);
        return $this;
    }

    /**
     * @throws DuplicatedSearchConstraintException
     */
    private function checkIfSearchIsDefined()
    {
        if ($this->query)
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

    /**
     * @param mixed $index
     * @return ElasticQueryBuilder
     */
    public function index($index)
    {
        $this->index = $index;
        return $this;
    }

    /**
     * @param mixed $sort
     * @return ElasticQueryBuilder
     */
    public function addSort($sort)
    {
        $this->sort[] = $sort;
        return $this;
    }

    /**
     * @param mixed $explain
     * @return ElasticQueryBuilder
     */
    public function explain($explain)
    {
        $this->explain = $explain;
        return $this;
    }

    /**
     * @param mixed $version
     * @return ElasticQueryBuilder
     */
    public function version($version)
    {
        $this->version = $version;
        return $this;
    }
}
