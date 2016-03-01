<?php

namespace specs\Neokike\LaravelElasticsearch\Queries\Ids;

use Neokike\LaravelElasticsearch\Exceptions\InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IdsQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('my_type', '1');
        $this->shouldHaveType('Neokike\LaravelElasticsearch\Queries\Ids\IdsQuery');
    }

    function it_returns_the_ids_query_as_an_array()
    {
        $this->beConstructedWith('my_type', [1, 2, 3]);
        $this->toArray()->shouldReturn(
            [
                'ids' =>
                    [
                        'type'   => 'my_type',
                        'values' => [1, 2, 3]
                    ]
            ]
        );
    }

    function it_returns_the_ids_query_as_json()
    {
        $this->beConstructedWith('my_type', '1');
        $this->toJson()->shouldReturn(
            json_encode([
                'ids' =>
                    [
                        'type'   => 'my_type',
                        'values' => ['1']
                    ]
            ])
        );
    }

    function it_returns_the_ids_query_as_json_with_int_param()
    {
        $this->beConstructedWith('my_type', 1);
        $this->toJson()->shouldReturn(
            json_encode([
                'ids' =>
                    [
                        'type'   => 'my_type',
                        'values' => [1]
                    ]
            ])
        );
    }

    function it_throws_exception_if_search_param_is_invalid()
    {
        $this->beConstructedWith('my_type', 100.10);
        $this->shouldThrow(new InvalidArgumentException('it must be an array of ids'))->duringInstantiation();
    }
}
