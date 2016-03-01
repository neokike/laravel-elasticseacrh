<?php

namespace specs\Neokike\LaravelElasticsearch\Queries\Match;

use Neokike\LaravelElasticsearch\Exceptions\InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ElasticMatchPhrasePrefixQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('field', 'value');

        $this->shouldHaveType('Neokike\LaravelElasticsearch\Queries\Match\ElasticMatchPhrasePrefixQuery');
    }

    function it_returns_the_match_phrase_prefix_query_as_an_array()
    {
        $this->beConstructedWith('field', 'value');
        $this->toArray()->shouldReturn(
            [
                'match_phrase_prefix' =>
                    [
                        'field' => [
                            'query' => 'value',
                        ]
                    ]
            ]
        );
    }

    function it_returns_the_match_phrase_prefix_query_as_an_array_with_max_expansions()
    {
        $this->beConstructedWith('field', 'value', ['max_expansions' => 10]);
        $this->toArray()->shouldReturn(
            [
                'match_phrase_prefix' =>
                    [
                        'field' => [
                            'query'          => 'value',
                            'max_expansions' => 10
                        ]
                    ]
            ]
        );
    }

    function it_returns_the_match_phrase_prefix_query_as_a_json_with_max_expansions()
    {
        $this->beConstructedWith('field', 'value', ['max_expansions' => 10]);
        $this->toJson()->shouldReturn(
            json_encode([
                'match_phrase_prefix' =>
                    [
                        'field' => [
                            'query'          => 'value',
                            'max_expansions' => 10
                        ]
                    ]
            ])
        );
    }
}
