<?php

namespace specs\Neokike\LaravelElasticsearchQueryBuilder\Queries\Common;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ElasticCommonTermsQuerySpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith('query');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearchQueryBuilder\Queries\Common\ElasticCommonTermsQuery');
    }

    function it_returns_the_common_terms_query_as_an_array()
    {
        $this->toArray()->shouldReturn(
            [
                'common' => [
                    'body' => [
                        'query' => 'query'
                    ],
                ]
            ]
        );
    }

    function it_returns_the_common_terms_query_as_an_array_with_params()
    {
        $params = [
            "cutoff_frequency"     => 0.001,
            "minimum_should_match" => [
                "low_freq"  => 2,
                "high_freq" => 3
            ]
        ];
        $this->beConstructedWith('query', $params);
        $this->toArray()->shouldReturn(
            [
                'common' => [
                    'body' => [
                        'query'                => 'query',
                        "cutoff_frequency"     => 0.001,
                        "minimum_should_match" => [
                            "low_freq"  => 2,
                            "high_freq" => 3
                        ]
                    ],
                ]
            ]
        );
    }

    function it_returns_the_common_terms_query_as_json_with_params()
    {
        $params = [
            "cutoff_frequency"     => 0.001,
            "minimum_should_match" => [
                "low_freq"  => 2,
                "high_freq" => 3
            ]
        ];
        $this->beConstructedWith('query', $params);
        $this->toJson()->shouldReturn(
            json_encode([
                'common' => [
                    'body' => [
                        'query'                => 'query',
                        "cutoff_frequency"     => 0.001,
                        "minimum_should_match" => [
                            "low_freq"  => 2,
                            "high_freq" => 3
                        ]
                    ],
                ]
            ])
        );
    }
}
