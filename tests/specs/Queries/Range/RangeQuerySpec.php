<?php

namespace specs\Neokike\LaravelElasticsearch\Queries\Range;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RangeQuerySpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith('fecha');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearch\Queries\Range\RangeQuery');
    }

    function it_assign_greater_than_equal_option()
    {
        $this->setGreaterThanEqual('2015-01-01 00:00:00')->shouldReturn($this);

        $this->gte->shouldReturn('2015-01-01 00:00:00');
    }

    function it_assign_greater_than_option()
    {
        $this->setGreaterThan('2015-01-01 00:00:00')->shouldReturn($this);

        $this->gt->shouldReturn('2015-01-01 00:00:00');
    }

    function it_assign_less_than_option()
    {
        $this->setLessThan('2015-01-01 00:00:00')->shouldReturn($this);

        $this->lt->shouldReturn('2015-01-01 00:00:00');
    }

    function it_assign_less_than_equal_option()
    {
        $this->setLessThanEqual('2015-01-01 00:00:00')->shouldReturn($this);

        $this->lte->shouldReturn('2015-01-01 00:00:00');
    }

    function it_assign_format_option()
    {
        $this->setFormat('dd/MM/yyyy||yyyy')->shouldReturn($this);

        $this->format->shouldReturn('dd/MM/yyyy||yyyy');
    }

    function it_assign_timezone_option()
    {
        $this->setTimezone('+01:00')->shouldReturn($this);

        $this->timezone->shouldReturn('+01:00');
    }

    function it_returns_the_range_query_as_an_array()
    {
        $this->setGreaterThanEqual('2015-01-01 00:00:00');
        $this->setLessThan('2015-01-01 00:00:00');

        $this->toArray()->shouldReturn(
            [
                'range' => [
                    'fecha' => [
                        'gte' => '2015-01-01 00:00:00',
                        'lt'  => '2015-01-01 00:00:00',
                    ]
                ]
            ]
        );
    }

    function it_returns_the_range_query_as_a_json_string()
    {
        $this->setGreaterThanEqual('2015-01-01 00:00:00');
        $this->setLessThan('2015-01-01 00:00:00');

        $this->toJson()->shouldReturn(json_encode(
            [
                'range' => [
                    'fecha' => [
                        'gte' => '2015-01-01 00:00:00',
                        'lt'  => '2015-01-01 00:00:00',
                    ]
                ]
            ]
        ));
    }

    function it_returns_the_range_query_as_an_array_with_format()
    {

        $this->setGreaterThanEqual('01/01/2015');
        $this->setLessThan('2015');
        $this->setFormat('dd/MM/yyyy||yyyy');


        $this->toArray()->shouldReturn(
            [
                'range' => [
                    'fecha' => [
                        'gte'      => '01/01/2015',
                        'lt'       => '2015',
                        'format' => 'dd/MM/yyyy||yyyy'
                    ]
                ]
            ]
        );
    }

    function it_returns_the_range_query_as_an_array_with_timezone()
    {

        $this->setGreaterThanEqual('01/01/2015');
        $this->setLessThan('2015');
        $this->setFormat('dd/MM/yyyy||yyyy');
        $this->setTimezone('+01:00');


        $this->toArray()->shouldReturn(
            [
                'range' => [
                    'fecha' => [
                        'gte'      => '01/01/2015',
                        'lt'       => '2015',
                        'format'   => 'dd/MM/yyyy||yyyy',
                        'timezone' => '+01:00'
                    ]
                ]
            ]
        );
    }
}
