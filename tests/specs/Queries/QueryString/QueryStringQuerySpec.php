<?php

namespace specs\Neokike\LaravelElasticsearchQueryBuilder\Queries\QueryString;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QueryStringQuerySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('this AND that OR thus');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearchQueryBuilder\Queries\QueryString\QueryStringQuery');
    }

    function it_return_query_string_query_as_an_array()
    {
        $this->toArray()->shouldReturn([
            'query_string' => [
                'query' => 'this AND that OR thus'
            ]
        ]);
    }

    function it_return_query_string_query_as_an_array_with_params()
    {
        $this->beConstructedWith('this AND that OR thus', ['fields' => ['field1', 'field2'], 'use_dis_max' => true]);

        $this->toArray()->shouldReturn([
            'query_string' => [
                'query'       => 'this AND that OR thus',
                'fields'      => ['field1', 'field2'],
                'use_dis_max' => true
            ]
        ]);
    }

    function it_return_query_string_query_as_json_with_params()
    {
        $this->beConstructedWith('this AND that OR thus', ['fields' => ['field1', 'field2'], 'use_dis_max' => true]);

        $this->toJson()->shouldReturn(
            json_encode([
                'query_string' => [
                    'query'       => 'this AND that OR thus',
                    'fields'      => ['field1', 'field2'],
                    'use_dis_max' => true
                ]
            ])
        );
    }
}
