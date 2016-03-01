<?php

namespace Neokike\LaravelElasticsearch;

use Neokike\LaravelElasticsearch\Exceptions\DuplicatedSearchConstraintException;
use Neokike\LaravelElasticsearch\Exceptions\InvalidMethodException;
use Neokike\LaravelElasticsearch\Queries\Bool\ElasticBoolQuery;
use Neokike\LaravelElasticsearch\Queries\Match\ElasticMatchAllQuery;
use Neokike\LaravelElasticsearch\Queries\Match\ElasticMatchPhrasePrefixQuery;
use Neokike\LaravelElasticsearch\Queries\Match\ElasticMatchPhraseQuery;
use Neokike\LaravelElasticsearch\Queries\Match\ElasticMatchQuery;

class ElasticQueryBuilder
{
    protected $size;
    protected $aggregates;
    protected $source = true;
    protected $min_score;
    protected $from;
    protected $type;
    protected $search;

    public function size($size)
    {
        $this->size = $size;

        return $this;
    }

    public function source($source)
    {
        $this->source = $source;

        return $this;
    }

    public function min_score($score)
    {
        $this->min_score = $score;

        return $this;
    }

    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    public function search($search)
    {
        $this->search = $search;

        return $this;
    }

    public function aggregates($aggregates)
    {
        $this->aggregates = $aggregates;

        return $this;
    }

    public function get()
    {
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

    public function searchArray()
    {
        $query = [];
        if ($this->search)
            $query['query'] = $this->search->toArray();

        if ($this->aggregates)
            $query['aggs'] = $this->aggregates->toArray();

        return $query;
    }

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

    public function match($field, $value, $params = [])
    {
        $query = new ElasticMatchQuery($field, $value, $params);
        $this->search($query);

        return $this;
    }

    public function matchAll($boost = 1.0)
    {
        $query = new ElasticMatchAllQuery($boost);
        $this->search($query);

        return $this;
    }

    public function matchPhrase($field, $value, $params = [])
    {
        $this->checkIfSearchIsDefined();
        $query = new ElasticMatchPhraseQuery($field, $value, $params);
        $this->search($query);

        return $this;
    }

    public function matchPhrasePreffix($field, $value, $params = [])
    {
        $this->checkIfSearchIsDefined();
        $query = new ElasticMatchPhrasePrefixQuery($field, $value, $params);
        $this->search($query);

        return $this;
    }

    public function bool()
    {
        $this->checkIfSearchIsDefined();
        $query = new ElasticBoolQuery();
        $this->search($query);
        return $this;
    }

    public function __call($method, $args)
    {
        if (!method_exists($this->search, $method))
            throw new InvalidMethodException($method);

        $this->search->$method($args[0]);
        return $this;
    }

    private function checkIfSearchIsDefined()
    {
        if ($this->search)
            throw new DuplicatedSearchConstraintException;
    }
}
