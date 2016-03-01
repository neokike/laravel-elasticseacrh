<?php

namespace specs\Neokike\LaravelElasticsearch\Queries\Bool;

use Neokike\LaravelElasticsearch\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearch\Queries\Match\ElasticMatchQuery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NotQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(new ElasticMatchQuery('nombre', 'pedro'));
        $this->shouldHaveType('Neokike\LaravelElasticsearch\Queries\Bool\NotQuery');
    }

    function it_returns_the_not_query_as_an_array()
    {
        $this->beConstructedWith(new ElasticMatchQuery('nombre', 'pedro'));
        $this->toArray()->shouldReturn(
            [
                'not' =>
                    [
                        'match' =>
                            [
                                'nombre' => [
                                    'query' => 'pedro'
                                ]
                            ]
                    ]
            ]
        );
    }

    function it_returns_the_not_query_as_json()
    {
        $this->beConstructedWith(new ElasticMatchQuery('nombre', 'pedro'));
        $this->toJson()->shouldReturn(
            json_encode([
                'not' =>
                    [
                        'match' =>
                            [
                                'nombre' => [
                                    'query' => 'pedro'
                                ]
                            ]
                    ]
            ])
        );
    }


    function it_throws_exception_if_query_param_is_invalid()
    {
        $this->beConstructedWith('nombre');
        $this->shouldThrow(new InvalidArgumentException('it must be a elasticsearch query'))->duringInstantiation();
    }
}
