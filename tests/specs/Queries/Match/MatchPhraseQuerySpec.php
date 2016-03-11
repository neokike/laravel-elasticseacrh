<?php

namespace specs\Neokike\LaravelElasticsearchQueryBuilder\Queries\Match;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MatchPhraseQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('field', 'value');
        $this->shouldHaveType('Neokike\LaravelElasticsearchQueryBuilder\Queries\Match\MatchPhraseQuery');
    }

    function it_returns_the_match_phrase_query_as_an_array()
    {
        $this->beConstructedWith('field', 'value');
        $this->toArray()->shouldReturn(
            [
                'match_phrase' =>
                    [
                        'field' => [
                            'query' => 'value',
                        ]
                    ]
            ]
        );
    }

    function it_returns_the_match_phrase_query_as_an_array_with_analyzer()
    {
        $this->beConstructedWith('field', 'value', ['analyzer' => 'my_analyzer']);
        $this->toArray()->shouldReturn(
            [
                'match_phrase' =>
                    [
                        'field' => [
                            'query'    => 'value',
                            'analyzer' => 'my_analyzer'
                        ]
                    ]
            ]
        );
    }

    function it_returns_the_match_phrase_query_as_a_json_with_analyzer()
    {
        $this->beConstructedWith('field', 'value', ['analyzer' => 'my_analyzer']);
        $this->toJson()->shouldReturn(
            json_encode([
                'match_phrase' =>
                    [
                        'field' => [
                            'query'    => 'value',
                            'analyzer' => 'my_analyzer'
                        ]
                    ]
            ])
        );
    }
}
