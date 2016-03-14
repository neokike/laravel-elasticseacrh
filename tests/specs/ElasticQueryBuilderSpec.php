<?php

namespace specs\Neokike\LaravelElasticsearchQueryBuilder;

use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\AggregatesInterface;
use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\QueryInterface;
use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\SortInterface;
use Neokike\LaravelElasticsearchQueryBuilder\Queries\Bool\ElasticBoolQuery;
use Neokike\LaravelElasticsearchQueryBuilder\Queries\Match\ElasticMatchAllQuery;
use Neokike\LaravelElasticsearchQueryBuilder\Queries\Match\ElasticMatchPhrasePrefixQuery;
use Neokike\LaravelElasticsearchQueryBuilder\Queries\Match\ElasticMatchPhraseQuery;
use Neokike\LaravelElasticsearchQueryBuilder\Queries\Match\ElasticMatchQuery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ElasticQueryBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearchQueryBuilder\ElasticQueryBuilder');
    }

    function it_assign_size_property()
    {
        $this->size(10)->shouldReturn($this);
        $this->size->shouldEqual(10);
    }

    function it_assign_index_property()
    {
        $this->index('my_index')->shouldReturn($this);
        $this->index->shouldEqual('my_index');
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

    function it_assign_explain_property()
    {
        $this->type('explain')->shouldReturn($this);
        $this->type->shouldEqual('explain');
    }

    function it_assign_query_property(QueryInterface $search)
    {
        $this->query($search)->shouldReturn($this);
        $this->query->shouldEqual($search);
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

    function it_return_the_query_array(QueryInterface $search, AggregatesInterface $aggregates)
    {
        $this->size(10);
        $this->from(0);
        $this->min_score(5);
        $this->source('source');
        $this->type('type');
        $this->index('my_index');
        $this->explain(true);
        $this->version(true);
        $search->toArray()->willReturn(['field' => 'value']);
        $aggregates->toArray()->willReturn(['field' => 'value']);
        $this->query($search);
        $this->aggregates($aggregates);
        $this->get()->shouldReturn([
            'body'  => [
                '_source'   => 'source',
                'size'      => 10,
                'from'      => 0,
                'min_score' => 5,
                'explain'   => true,
                'version'   => true,
                'query'     => ['field' => 'value'],
                'aggs'      => ['field' => 'value']
            ],
            'index' => 'my_index',
            'type'  => 'type',
        ]);
    }

    function it_return_the_raw_query_array()
    {
        $this->raw(['body' => []]);
        $this->get()->shouldReturn(['body' => []]);
    }

    function it_returns_the_query_array(QueryInterface $search, AggregatesInterface $aggregates)
    {
        $search->toArray()->willReturn(['field' => 'value']);
        $aggregates->toArray()->willReturn(['field' => 'value']);
        $this->query($search);
        $this->aggregates($aggregates);


        $this->searchArray()->shouldReturn([
            'query' => ['field' => 'value'],
            'aggs'  => ['field' => 'value']
        ]);
    }

    function it_returns_the_query_array_with_sort(QueryInterface $search,
                                                  AggregatesInterface $aggregates,
                                                  SortInterface $sort1,
                                                  SortInterface $sort2)
    {
        $this->size(10);
        $this->from(0);
        $this->min_score(5);
        $this->source('source');
        $this->type('type');
        $this->index('my_index');
        $search->toArray()->willReturn(['field' => 'value']);
        $aggregates->toArray()->willReturn(['field' => 'value']);
        $sort1->toArray()->willReturn([
            'field' => [
                'mode'  => 'avg',
                'order' => 'asc'
            ]
        ]);
        $sort2->toArray()->willReturn([
            '_geo_distance' => [
                'mode'         => 'avg',
                'order'        => 'asc',
                'pin.location' => [-70, 40],
                'unit'         => 'km'
            ]
        ]);
        $this->query($search);
        $this->aggregates($aggregates);
        $this->addSort($sort1);
        $this->addSort($sort2);
        $this->get()->shouldReturn([
            'body'  => [
                '_source'   => 'source',
                'size'      => 10,
                'from'      => 0,
                'min_score' => 5,
                'query'     => ['field' => 'value'],
                'aggs'      => ['field' => 'value'],
                'sort'      => [
                    [
                        'field' => [
                            'mode'  => 'avg',
                            'order' => 'asc'
                        ]
                    ],
                    [
                        '_geo_distance' => [
                            'mode'         => 'avg',
                            'order'        => 'asc',
                            'pin.location' => [-70, 40],
                            'unit'         => 'km'
                        ]
                    ]
                ]
            ],
            'index' => 'my_index',
            'type'  => 'type',
        ]);
    }

    function it_return_the_search_json(QueryInterface $search, AggregatesInterface $aggregates)
    {
        $search->toArray()->willReturn(['field' => 'value']);
        $aggregates->toArray()->willReturn(['field' => 'value']);
        $this->query($search);
        $this->aggregates($aggregates);
        $this->searchJson()->shouldReturn(json_encode([
            'query' => ['field' => 'value'],
            'aggs'  => ['field' => 'value']
        ]));
    }
}
