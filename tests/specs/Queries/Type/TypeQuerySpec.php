<?php

namespace specs\Neokike\LaravelElasticsearchQueryBuilder\Queries\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TypeQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('my_type');
        $this->shouldHaveType('Neokike\LaravelElasticsearchQueryBuilder\Queries\Type\TypeQuery');
    }

    function it_returns_the_type_query_as_an_array()
    {
        $this->beConstructedWith('my_type');
        $this->toArray()->shouldReturn(
            [
                'type' =>
                    [
                        'value' => 'my_type'
                    ]
            ]
        );
    }

    function it_returns_the_type_query_as_json()
    {
        $this->beConstructedWith('my_type');
        $this->toJson()->shouldReturn(
            json_encode([
                'type' =>
                    [
                        'value' => 'my_type'
                    ]
            ])
        );
    }
}
