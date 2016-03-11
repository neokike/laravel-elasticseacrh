<?php

namespace specs\Neokike\LaravelElasticsearchQueryBuilder\Sort;

use Neokike\LaravelElasticsearchQueryBuilder\Queries\Term\TermQuery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SortQuerySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('field');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearchQueryBuilder\Sort\SortQuery');
    }

    function it_returns_the_sort_as_an_array()
    {
        $this->beConstructedWith('field');
        $this->toArray()->shouldReturn(
            [
                'field'
            ]
        );
    }

    function it_returns_the_sort_as_an_array_with_options()
    {
        $this->beConstructedWith('field');
        $this->mode('avg');
        $this->order('asc');
        $this->toArray()->shouldReturn(
            [
                'field' => [
                    'mode'  => 'avg',
                    'order' => 'asc'
                ]
            ]
        );
    }

    function it_returns_the_sort_as_an_array_with_options_and_param()
    {
        $this->beConstructedWith('_geo_distance');
        $this->mode('avg');
        $this->order('asc');
        $this->param('pin.location', [-70, 40]);
        $this->param('unit', 'km');
        $this->toArray()->shouldReturn(
            [
                '_geo_distance' => [
                    'mode'         => 'avg',
                    'order'        => 'asc',
                    'pin.location' => [-70, 40],
                    'unit'         => 'km'
                ]
            ]
        );
    }

    function it_returns_the_sort_as_an_array_with_options_filter_and_param()
    {
        $this->beConstructedWith('_geo_distance');
        $filter = new TermQuery("offer.color", 'blue');
        $this->mode('avg');
        $this->order('asc');
        $this->nestedPath('offer');
        $this->nestedFilter($filter);
        $this->param('pin.location', [-70, 40]);
        $this->param('unit', 'km');
        $this->toArray()->shouldReturn(
            [
                '_geo_distance' => [
                    'mode'          => 'avg',
                    'order'         => 'asc',
                    'nested_path'   => 'offer',
                    'nested_filter' => [
                        'term' => ['offer.color' => 'blue']
                    ],
                    'pin.location'  => [-70, 40],
                    'unit'          => 'km'
                ]
            ]
        );
    }

    function it_returns_the_sort_as_a_json_with_options()
    {
        $this->beConstructedWith('field');
        $this->mode('avg');
        $this->order('asc');
        $this->toJson()->shouldReturn(
            json_encode([
                'field' => [
                    'mode'  => 'avg',
                    'order' => 'asc'
                ]
            ])
        );
    }
}
