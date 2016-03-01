<?php

namespace specs\Neokike\LaravelElasticsearch\Queries\ConstantScore;

use Neokike\LaravelElasticsearch\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearch\Queries\Match\ElasticMatchQuery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConstantScoreQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(new ElasticMatchQuery('nombre', 'pedro'), 1.2);
        $this->shouldHaveType('Neokike\LaravelElasticsearch\Queries\ConstantScore\ConstantScoreQuery');
    }

    function it_returns_the_constant_score_query_as_an_array()
    {
        $this->beConstructedWith(new ElasticMatchQuery('nombre', 'pedro'), 1.2);
        $this->toArray()->shouldReturn(
            [
                'constant_score' =>
                    [
                        'match' =>
                            [
                                'nombre' => [
                                    'query' => 'pedro'
                                ]
                            ]
                        ,
                        'boost' => 1.2
                    ]
            ]
        );
    }

    function it_returns_the_constant_score_query_as_json()
    {
        $this->beConstructedWith(new ElasticMatchQuery('nombre', 'pedro'), 1.2);
        $this->toJson()->shouldReturn(
            json_encode([
                'constant_score' =>
                    [
                        'match' =>
                            [
                                'nombre' => [
                                    'query' => 'pedro'
                                ]
                            ]
                        ,
                        'boost' => 1.2
                    ]
            ])
        );
    }


    function it_throws_exception_if_query_param_is_invalid()
    {
        $this->beConstructedWith('nombre', 1.2);
        $this->shouldThrow(new InvalidArgumentException('it must be a elasticsearch query'))->duringInstantiation();
    }
}
