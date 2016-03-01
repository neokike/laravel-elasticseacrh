<?php

namespace specs\Neokike\LaravelElasticsearch\Queries\Bool;

use Neokike\LaravelElasticsearch\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearch\Queries\Match\ElasticMatchQuery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AndQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith([new ElasticMatchQuery('nombre', 'pedro'), new ElasticMatchQuery('nombre', 'pedro2')]);
        $this->shouldHaveType('Neokike\LaravelElasticsearch\Queries\Bool\AndQuery');
    }

    function it_returns_the_and_query_as_an_array()
    {
        $this->beConstructedWith([new ElasticMatchQuery('nombre', 'pedro'), new ElasticMatchQuery('nombre', 'pedro2')]);
        $this->toArray()->shouldReturn(
            [
                'and' =>
                    [
                        [
                            'match' =>
                                [
                                    'nombre' => [
                                        'query' => 'pedro'
                                    ]
                                ]
                        ], [
                            'match' =>
                                [
                                    'nombre' => [
                                        'query' => 'pedro2'
                                    ]
                                ]
                        ]
                    ]
            ]
        );
    }

    function it_returns_the_and_query_as_json()
    {
        $this->beConstructedWith([new ElasticMatchQuery('nombre', 'pedro'), new ElasticMatchQuery('nombre', 'pedro2')]);

        $this->toJson()->shouldReturn(
            json_encode([
                'and' =>
                    [
                        [
                            'match' =>
                                [
                                    'nombre' => [
                                        'query' => 'pedro'
                                    ]
                                ]
                        ], [
                            'match' =>
                                [
                                    'nombre' => [
                                        'query' => 'pedro2'
                                    ]
                                ]
                        ]
                    ]
            ])
        );
    }


    function it_throws_exception_if_query_param_is_not_an_array()
    {
        $this->beConstructedWith('hola');
        $this->shouldThrow(new InvalidArgumentException('it must be an array of elasticsearch queries'))->duringInstantiation();
    }

    function it_throws_exception_if_query_param_is_an_array_of_invalid_values()
    {
        $this->beConstructedWith([1, 2, 3]);
        $this->shouldThrow(new InvalidArgumentException('not an elastisearch query'))->duringInstantiation();
    }
}
