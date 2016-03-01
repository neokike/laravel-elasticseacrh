<?php

namespace specs\Neokike\LaravelElasticsearch\Queries\Filtered;

use Neokike\LaravelElasticsearch\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearch\Exceptions\NotEnoughArgumentsException;
use Neokike\LaravelElasticsearch\Interfaces\FilterInterface;
use Neokike\LaravelElasticsearch\Interfaces\QueryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ElasticFilteredQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearch\Queries\Filtered\ElasticFilteredQuery');
    }

    function it_assign_the_query(QueryInterface $query)
    {
        $this->setQuery($query)->shouldReturn($this);

        $this->query->shouldReturn($query);
    }


    function it_assign_filter_query(FilterInterface $query)
    {
        $this->setFilter($query)->shouldReturn($this);

        $this->filter->shouldReturn($query);
    }

    function it_throws_exception_if_query_is_not_a_valid_elasticsearch_query()
    {
        $query = '';
        $this->shouldThrow(new InvalidArgumentException('it must be a query object'))->duringSetQuery($query);
    }

    function it_throws_exception_if_filter_is_not_a_filter()
    {
        $filter = '';
        $this->shouldThrow(new InvalidArgumentException('it must be a filter object'))->duringSetFilter($filter);
    }

    function it_returns_the_filtered_query_as_an_array(QueryInterface $query, FilterInterface $filter)
    {
        $query->toArray()->willReturn(['field' => 'value']);
        $filter->toArray()->willReturn(['field' => 'value']);

        $this->setQuery($query);
        $this->setFilter($filter);

        $this->toArray()->shouldReturn(
            [
                'filtered' => [
                    'query'  => [['field' => 'value']],
                    'filter' => [['field' => 'value']]
                ]
            ]
        );
    }

    function it_returns_the_filtered_query_as_a_json(QueryInterface $query, FilterInterface $filter)
    {
        $query->toArray()->willReturn(['field' => 'value']);
        $filter->toArray()->willReturn(['field' => 'value']);

        $this->setQuery($query);
        $this->setFilter($filter);

        $this->toJson()->shouldReturn(
            json_encode([
                'filtered' => [
                    'query'  => [['field' => 'value']],
                    'filter' => [['field' => 'value']]
                ]
            ])
        );
    }

    function it_returns_the_filtered_query_as_an_array_with_just_a_filter(FilterInterface $filter)
    {
        $filter->toArray()->willReturn(['field' => 'value']);

        $this->setFilter($filter);

        $this->toArray()->shouldReturn(
            [
                'filtered' => [
                    'filter' => [['field' => 'value']]
                ]
            ]
        );
    }

    function it_throws_exception_when_there_is_not_options_defined_and_return_array()
    {
        $this->shouldThrow(new NotEnoughArgumentsException())->duringToArray();
    }

    function it_throws_exception_when_there_is_not_options_defined_and_return_json()
    {
        $this->shouldThrow(new NotEnoughArgumentsException())->duringToJson();
    }
}
