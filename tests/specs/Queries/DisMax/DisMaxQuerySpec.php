<?php

namespace specs\Neokike\LaravelElasticsearchQueryBuilder\Queries\DisMax;

use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearchQueryBuilder\Queries\Match\ElasticMatchQuery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DisMaxQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith([new ElasticMatchQuery('nombre', 'pedro'), new ElasticMatchQuery('nombre', 'pedro2')], 1.2, 0.7);
        $this->shouldHaveType('Neokike\LaravelElasticsearchQueryBuilder\Queries\DisMax\DisMaxQuery');
    }

    function it_returns_the_dis_max_query_as_an_array()
    {
        $this->beConstructedWith([new ElasticMatchQuery('nombre', 'pedro'), new ElasticMatchQuery('nombre', 'pedro2')], 1.2, 0.7);
        $this->toArray()->shouldReturn(
            [
                'dis_max' =>
                    [
                        'queries'     => [
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
                        ],
                        'boost'       => 1.2,
                        'tie_breaker' => 0.7
                    ]
            ]
        );
    }

    function it_returns_the_dis_max_query_as_json()
    {
        $this->beConstructedWith([new ElasticMatchQuery('nombre', 'pedro'), new ElasticMatchQuery('nombre', 'pedro2')], 1.2, 0.7);

        $this->toJson()->shouldReturn(
            json_encode([
                'dis_max' =>
                    [
                        'queries'     => [
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
                        ],
                        'boost'       => 1.2,
                        'tie_breaker' => 0.7
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
        $this->beConstructedWith([1,2,3], 1.2, 0.7);
        $this->shouldThrow(new InvalidArgumentException('not an elastisearch query'))->duringInstantiation();
    }

}
