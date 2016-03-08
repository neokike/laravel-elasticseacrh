<?php

namespace specs\Neokike\LaravelElasticsearchQueryBuilder\Queries\Exists;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExistsQuerySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('user');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearchQueryBuilder\Queries\Exists\ExistsQuery');
    }

    function it_returns_exists_query_as_an_array()
    {
        $this->beConstructedWith('nombre');

        $this->toArray()->shouldReturn(
            [
                'exists' => ['field' => 'nombre']
            ]
        );
    }

    function it_returns_exists_query_as_json()
    {
        $this->beConstructedWith('nombre');

        $this->toJson()->shouldReturn(
            json_encode([
                'exists' => [
                    'field' => 'nombre'
                ]
            ])
        );
    }
}
