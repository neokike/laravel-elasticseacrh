<?php

namespace specs\Neokike\LaravelElasticsearchQueryBuilder\Queries\Bool;

use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\NotEnoughArgumentsException;
use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\FilterInterface;
use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\QueryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\InvalidArgumentException;

class ElasticBoolQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearchQueryBuilder\Queries\Bool\ElasticBoolQuery');
    }

    function it_assign_must_query(QueryInterface $query)
    {
        $this->setMust($query)->shouldReturn($this);

        $this->must->shouldReturn([$query]);
    }

    function it_assign_two_must_query(QueryInterface $query, QueryInterface $query2)
    {
        $this->setMust($query)->shouldReturn($this);
        $this->setMust($query2)->shouldReturn($this);

        $this->must->shouldReturn([$query, $query2]);
    }

    function it_assign_must_not_query(QueryInterface $query)
    {
        $this->setMustNot($query)->shouldReturn($this);

        $this->mustNot->shouldReturn([$query]);
    }

    function it_assign_should_query(QueryInterface $query)
    {
        $this->setShould($query)->shouldReturn($this);

        $this->should->shouldReturn([$query]);
    }

    function it_assign_filter_query(FilterInterface $query)
    {
        $this->setFilter($query)->shouldReturn($this);

        $this->filter->shouldReturn([$query]);
    }

    function it_assigns_minimum_should_match_parameter()
    {
        $this->setMinimunShouldMatch(1)->shouldReturn($this);

        $this->minimum_should_match->shouldReturn(1);
    }

    function it_assigns_boost_parameter()
    {
        $this->setBoost(1)->shouldReturn($this);

        $this->boost->shouldReturn(1);
    }

    function it_throws_exception_if_must_is_not_query()
    {
        $query = '';
        $this->shouldThrow(new InvalidArgumentException('it must be a query object'))->duringSetMust($query);
    }

    function it_throws_exception_if_must_not_is_not_query()
    {
        $query = '';
        $this->shouldThrow(new InvalidArgumentException('it must be a query object'))->duringSetMustNot($query);
    }

    function it_throws_exception_if_should_is_not_query()
    {
        $query = '';
        $this->shouldThrow(new InvalidArgumentException('it must be a query object'))->duringSetShould($query);
    }

    function it_throws_exception_if_filter_is_not_a_filter()
    {
        $filter = '';
        $this->shouldThrow(new InvalidArgumentException('it must be a filter object'))->duringSetFilter($filter);
    }

    function it_throws_exception_if_minimum_should_match_is_not_integer()
    {
        $this->shouldThrow(new InvalidArgumentException('it must be an integer'))->duringSetMinimunShouldMatch('hola');
    }

    function it_throws_exception_if_boost_is_not_integer()
    {
        $this->shouldThrow(new InvalidArgumentException('it must be an integer'))->duringSetBoost('hola');
    }

    function it_returns_the_bool_query_as_an_array(QueryInterface $queryMust, QueryInterface $queryMustNot, QueryInterface $queryShould, FilterInterface $filter)
    {
        $queryMust->toArray()->willReturn(['field' => 'value']);
        $queryMustNot->toArray()->willReturn(['field' => 'value']);
        $queryShould->toArray()->willReturn(['field' => 'value']);
        $filter->toArray()->willReturn(['field' => 'value']);

        $this->setMust($queryMust);
        $this->setMustNot($queryMustNot);
        $this->setShould($queryShould);
        $this->setFilter($filter);

        $this->toArray()->shouldReturn(
            [
                'bool' => [
                    'must'     => [['field' => 'value']],
                    'must_not' => [['field' => 'value']],
                    'should'   => [['field' => 'value']],
                    'filter'   => [['field' => 'value']]
                ]
            ]
        );
    }

    function it_returns_the_bool_query_as_an_array_with_boost(QueryInterface $queryMust, QueryInterface $queryMustNot, QueryInterface $queryShould)
    {
        $queryMust->toArray()->willReturn(['field' => 'value']);
        $queryMustNot->toArray()->willReturn(['field' => 'value']);
        $queryShould->toArray()->willReturn(['field' => 'value']);

        $this->setMust($queryMust);
        $this->setMustNot($queryMustNot);
        $this->setShould($queryShould);
        $this->setBoost(1);

        $this->toArray()->shouldReturn(
            [
                'bool' => [
                    'must'     => [['field' => 'value']],
                    'must_not' => [['field' => 'value']],
                    'should'   => [['field' => 'value']],
                    'boost'    => 1
                ]
            ]
        );
    }

    function it_returns_the_bool_query_as_an_array_with_minimum_should_match(QueryInterface $queryMust, QueryInterface $queryMustNot, QueryInterface $queryShould)
    {

        $this->beConstructedWith(['minimum_should_match' => 1]);
        $queryMust->toArray()->willReturn(['field' => 'value']);
        $queryMustNot->toArray()->willReturn(['field' => 'value']);
        $queryShould->toArray()->willReturn(['field' => 'value']);

        $this->setMust($queryMust);
        $this->setMustNot($queryMustNot);
        $this->setShould($queryShould);

        $this->toArray()->shouldReturn(
            [
                'bool' => [
                    'must'                 => [['field' => 'value']],
                    'must_not'             => [['field' => 'value']],
                    'should'               => [['field' => 'value']],
                    'minimum_should_match' => 1
                ]
            ]
        );
    }

    function it_returns_the_bool_query_as_a_json(QueryInterface $queryMust, QueryInterface $queryMustNot, QueryInterface $queryShould, FilterInterface $filter)
    {
        $queryMust->toArray()->willReturn(['field' => 'value']);
        $queryMustNot->toArray()->willReturn(['field' => 'value']);
        $queryShould->toArray()->willReturn(['field' => 'value']);
        $filter->toArray()->willReturn(['field' => 'value']);

        $this->setMust($queryMust);
        $this->setMustNot($queryMustNot);
        $this->setShould($queryShould);
        $this->setFilter($filter);
        $this->toJson()->shouldReturn(
            json_encode([
                'bool' => [
                    'must'     => [['field' => 'value']],
                    'must_not' => [['field' => 'value']],
                    'should'   => [['field' => 'value']],
                    'filter'   => [['field' => 'value']]
                ]
            ])
        );
    }

    function it_returns_the_bool_query_as_an_array_with_two_options(QueryInterface $queryMust, QueryInterface $queryMustNot)
    {
        $queryMust->toArray()->willReturn(['field' => 'value']);
        $queryMustNot->toArray()->willReturn(['field' => 'value']);

        $this->setMust($queryMust);
        $this->setMustNot($queryMustNot);

        $this->toArray()->shouldReturn(
            [
                'bool' => [
                    'must'     => [['field' => 'value']],
                    'must_not' => [['field' => 'value']]
                ]
            ]
        );
    }

    function it_returns_the_bool_query_as_an_array_with_one_options(QueryInterface $queryMustNot)
    {
        $queryMustNot->toArray()->willReturn(['field' => 'value']);

        $this->setMustNot($queryMustNot);

        $this->toArray()->shouldReturn(
            [
                'bool' => [
                    'must_not' => [['field' => 'value']]
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
