<?php

namespace specs\Neokike\LaravelElasticsearchQueryBuilder\Queries\Match;

use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MatchQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('field', 'value');
        $this->shouldHaveType('Neokike\LaravelElasticsearchQueryBuilder\Queries\Match\MatchQuery');
    }

    function it_returns_the_match_query_as_an_array()
    {
        $this->beConstructedWith('field', 'value');
        $this->toArray()->shouldReturn(
            [
                'match' =>
                    [
                        'field' => [
                            'query' => 'value'
                        ]
                    ]
            ]
        );
    }


    function it_returns_the_match_query_as_an_array_with_other_params()
    {
        $this->beConstructedWith('field', 'value', ['boost' => 1.0, 'operator' => 'and', 'zero_terms_query' => 'all', 'cutoff_frequency' => 0.001, 'fuzziness' => 'AUTO']);
        $this->toArray()->shouldReturn(
            [
                'match' =>
                    [
                        'field' => [
                            'query'            => 'value',
                            'boost'            => 1.0,
                            'operator'         => 'and',
                            'zero_terms_query' => 'all',
                            'cutoff_frequency' => 0.001,
                            'fuzziness'        => 'AUTO',
                        ]
                    ]
            ]
        );
    }

    function it_returns_the_match_query_as_a_json()
    {
        $this->beConstructedWith('field', 'value', ['boost' => 1.0, 'operator' => 'and', 'zero_terms_query' => 'all', 'cutoff_frequency' => 0.001, 'fuzziness' => 'AUTO']);
        $this->toJson()->shouldReturn(
            json_encode([
                'match' =>
                    [
                        'field' => [
                            'query'            => 'value',
                            'boost'            => 1.0,
                            'operator'         => 'and',
                            'zero_terms_query' => 'all',
                            'cutoff_frequency' => 0.001,
                            'fuzziness'        => 'AUTO',
                        ]
                    ]
            ])
        );
    }
}
