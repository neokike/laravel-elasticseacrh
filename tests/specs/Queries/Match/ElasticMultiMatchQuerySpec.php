<?php

namespace specs\Neokike\LaravelElasticsearch\Queries\Match;

use Neokike\LaravelElasticsearch\Exceptions\InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ElasticMultiMatchQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(['field'], 'value');
        $this->shouldHaveType('Neokike\LaravelElasticsearch\Queries\Match\ElasticMultiMatchQuery');
    }

    function it_throw_an_exception_if_type_is_invalid()
    {
        $this->beConstructedWith(['field'], 'value', 'all');
        $this->shouldThrow(new InvalidArgumentException('the type must be best_fields, most_fields, cross_fields, phrase, phrase_prefix'))->duringInstantiation();
    }

    function it_throw_an_exception_if_fields_is_not_an_array()
    {
        $this->beConstructedWith('field', 'value');
        $this->shouldThrow(new InvalidArgumentException('the fields must be an array of fields'))->duringInstantiation();
    }

    function it_throw_an_exception_if_tie_breaker_is_not_float()
    {
        $this->beConstructedWith(['field'], 'value', 'best_fields', 'all');
        $this->shouldThrow(new InvalidArgumentException('the tie_breaker must be a float value'))->duringInstantiation();
    }

    function it_returns_the_match_query_as_an_array()
    {
        $this->beConstructedWith(['fields'], 'value');
        $this->toArray()->shouldReturn(
            [
                'multi_match' =>
                    [
                        'query'  => 'value',
                        'type'   => 'best_fields',
                        'fields' => ['fields'],
                    ]
            ]
        );
    }

    function it_returns_the_match_query_as_an_array_with_tie_breaker()
    {
        $this->beConstructedWith(['fields'], 'value', 'best_fields', 0.3);
        $this->toArray()->shouldReturn(
            [
                'multi_match' =>
                    [
                        'query'       => 'value',
                        'type'        => 'best_fields',
                        'fields'      => ['fields'],
                        'tie_breaker' => 0.3
                    ]
            ]
        );
    }

    function it_returns_the_match_query_as_json()
    {
        $this->beConstructedWith(['fields'], 'value');
        $this->toJson()->shouldReturn(
            json_encode([
                'multi_match' =>
                    [
                        'query'  => 'value',
                        'type'   => 'best_fields',
                        'fields' => ['fields']
                    ]
            ])
        );
    }
}
