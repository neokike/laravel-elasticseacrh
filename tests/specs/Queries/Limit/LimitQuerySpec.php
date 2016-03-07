<?php

namespace specs\Neokike\LaravelElasticsearchQueryBuilder\Queries\Limit;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LimitQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(100);
        $this->shouldHaveType('Neokike\LaravelElasticsearchQueryBuilder\Queries\Limit\LimitQuery');
    }

    function it_returns_the_type_query_as_an_array()
    {
        $this->beConstructedWith(100);
        $this->toArray()->shouldReturn(
            [
                'limit' =>
                    [
                        'value' => 100
                    ]
            ]
        );
    }

    function it_returns_the_type_query_as_json()
    {
        $this->beConstructedWith(100);
        $this->toJson()->shouldReturn(
            json_encode([
                'limit' =>
                    [
                        'value' => 100
                    ]
            ])
        );
    }
}
