<?php

namespace specs\Neokike\LaravelElasticsearchQueryBuilder\Queries\Fuzzy;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FuzzyQuerySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('user', 'ki');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearchQueryBuilder\Queries\Fuzzy\FuzzyQuery');
    }

    function it_returns_the_fuzzy_query_as_an_array()
    {
        $this->beConstructedWith('field', 'value');
        $this->toArray()->shouldReturn(
            [
                'fuzzy' =>
                    [
                        'field' => [
                            'value' => 'value'
                        ]
                    ]
            ]
        );
    }


    function it_returns_the_fuzzy_query_as_an_array_with_other_params()
    {
        $this->beConstructedWith('field', 'value', ['boost' => 1.0, 'operator' => 'and', 'zero_terms_query' => 'all', 'cutoff_frequency' => 0.001, 'fuzziness' => 'AUTO']);
        $this->toArray()->shouldReturn(
            [
                'fuzzy' =>
                    [
                        'field' => [
                            'value'            => 'value',
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

    function it_returns_the_fuzzy_query_as_a_json()
    {
        $this->beConstructedWith('field', 'value', ['boost' => 1.0, 'operator' => 'and', 'zero_terms_query' => 'all', 'cutoff_frequency' => 0.001, 'fuzziness' => 'AUTO']);
        $this->toJson()->shouldReturn(
            json_encode([
                'fuzzy' =>
                    [
                        'field' => [
                            'value'            => 'value',
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
