<?php

namespace specs\Neokike\LaravelElasticsearch;

use Neokike\LaravelElasticsearch\Interfaces\AggregatesInterface;
use Neokike\LaravelElasticsearch\Interfaces\QueryInterface;
use Neokike\LaravelElasticsearch\Queries\Bool\ElasticBoolQuery;
use Neokike\LaravelElasticsearch\Queries\Match\ElasticMatchAllQuery;
use Neokike\LaravelElasticsearch\Queries\Match\ElasticMatchPhrasePrefixQuery;
use Neokike\LaravelElasticsearch\Queries\Match\ElasticMatchPhraseQuery;
use Neokike\LaravelElasticsearch\Queries\Match\ElasticMatchQuery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ElasticQueryBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearch\ElasticQueryBuilder');
    }

    function it_assign_size_property()
    {
        $this->size(10)->shouldReturn($this);
        $this->size->shouldEqual(10);
    }

    function it_assign_source_property()
    {
        $this->source('source')->shouldReturn($this);
        $this->source->shouldEqual('source');
    }

    function it_assign_min_score_property()
    {
        $this->min_score(5)->shouldReturn($this);
        $this->min_score->shouldEqual(5);
    }

    function it_assign_from_property()
    {
        $this->from(0)->shouldReturn($this);
        $this->from->shouldEqual(0);
    }

    function it_assign_type_property()
    {
        $this->type('type')->shouldReturn($this);
        $this->type->shouldEqual('type');
    }

    function it_assign_search_property(QueryInterface $search)
    {
        $this->search($search)->shouldReturn($this);
        $this->search->shouldEqual($search);
    }

    function it_assign_aggregates_property(AggregatesInterface $aggregates)
    {
        $this->aggregates($aggregates)->shouldReturn($this);
        $this->aggregates->shouldEqual($aggregates);
    }

    function it_assign_raw_property()
    {
        $this->raw(['body' => []])->shouldReturn($this);
        $this->raw->shouldEqual(['body' => []]);
    }

    function it_return_the_search_array(QueryInterface $search, AggregatesInterface $aggregates)
    {
        $this->size(10);
        $this->from(0);
        $this->min_score(5);
        $this->source('source');
        $this->type('type');
        $search->toArray()->willReturn(['field' => 'value']);
        $aggregates->toArray()->willReturn(['field' => 'value']);
        $this->search($search);
        $this->aggregates($aggregates);
        $this->get()->shouldReturn([
            'body' => [
                '_source'   => 'source',
                'size'      => 10,
                'from'      => 0,
                'min_score' => 5,
                'query'     => ['field' => 'value'],
                'aggs'      => ['field' => 'value']
            ],
            'type' => 'type',
        ]);
    }

    function it_return_the_raw_search_array()
    {
        $this->raw(['body' => []]);
        $this->get()->shouldReturn(['body' => []]);
    }

    function it_returns_the_search_array(QueryInterface $search, AggregatesInterface $aggregates)
    {
        $search->toArray()->willReturn(['field' => 'value']);
        $aggregates->toArray()->willReturn(['field' => 'value']);
        $this->search($search);
        $this->aggregates($aggregates);


        $this->searchArray()->shouldReturn([
            'query' => ['field' => 'value'],
            'aggs'  => ['field' => 'value']
        ]);
    }

    function it_return_the_search_json(QueryInterface $search, AggregatesInterface $aggregates)
    {
        $search->toArray()->willReturn(['field' => 'value']);
        $aggregates->toArray()->willReturn(['field' => 'value']);
        $this->search($search);
        $this->aggregates($aggregates);
        $this->searchJson()->shouldReturn(json_encode([
            'query' => ['field' => 'value'],
            'aggs'  => ['field' => 'value']
        ]));
    }
}
