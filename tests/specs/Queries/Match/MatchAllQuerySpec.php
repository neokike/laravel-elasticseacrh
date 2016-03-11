<?php

namespace specs\Neokike\LaravelElasticsearchQueryBuilder\Queries\Match;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MatchAllQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearchQueryBuilder\Queries\Match\MatchAllQuery');
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
