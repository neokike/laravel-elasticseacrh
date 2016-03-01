<?php

namespace specs\Neokike\LaravelElasticsearch\Queries\Match;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ElasticMatchAllQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearch\Queries\Match\ElasticMatchAllQuery');
    }

    function it_returns_the_match_all_query_as_an_array()
    {
        $this->beConstructedWith(['boost' => 1.0]);
        $this->toArray()->shouldReturn(
            [
                'match_all' =>
                    [
                        'boost' => 1.0
                    ]
            ]
        );
    }

    function it_returns_the_match_all_query_as_json()
    {
        $this->toJson()->shouldReturn(
            json_encode([
                'match_all' => []
            ])
        );
    }
}
