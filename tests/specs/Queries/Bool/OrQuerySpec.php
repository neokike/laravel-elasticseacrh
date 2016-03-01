<?php

namespace specs\Neokike\LaravelElasticsearch\Queries\Bool;

use Neokike\LaravelElasticsearch\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearch\Queries\Match\ElasticMatchQuery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OrQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith([new ElasticMatchQuery('nombre', 'pedro'), new ElasticMatchQuery('nombre', 'pedro2')], 1.2, 0.7);
        $this->shouldHaveType('Neokike\LaravelElasticsearch\Queries\Bool\OrQuery');
    }


    function it_returns_the_or_query_as_an_array()
    {
        $this->beConstructedWith([new ElasticMatchQuery('nombre', 'pedro'), new ElasticMatchQuery('nombre', 'pedro2')], 1.2, 0.7);
        $this->toArray()->shouldReturn(
            [
                'or' =>
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

    function it_returns_the_or_query_as_json()
    {
        $this->beConstructedWith([new ElasticMatchQuery('nombre', 'pedro'), new ElasticMatchQuery('nombre', 'pedro2')], 1.2, 0.7);

        $this->toJson()->shouldReturn(
            json_encode([
                'or' =>
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
        $this->beConstructedWith('hola', 1.2, 0.7);
        $this->shouldThrow(new InvalidArgumentException('it must be an array of elasticsearch queries'))->duringInstantiation();
    }

    function it_throws_exception_if_query_param_is_an_array_of_invalid_values()
    {
        $this->beConstructedWith([1, 2, 3], 1.2, 0.7);
        $this->shouldThrow(new InvalidArgumentException('not an elastisearch query'))->duringInstantiation();
    }
}
