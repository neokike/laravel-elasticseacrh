<?php

namespace specs\Neokike\LaravelElasticsearch\Queries\Prefix;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PrefixQuerySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('user', 'Kymchy');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearch\Queries\Prefix\PrefixQuery');
    }

    function it_returns_prefix_query_as_an_array()
    {
        $this->beConstructedWith('nombre', 'pedro');

        $this->toArray()->shouldReturn(
            [
                'prefix' => ['nombre' => 'pedro']
            ]
        );
    }

    function it_returns_prefix_query_as_an_array_with_params()
    {
        $this->beConstructedWith('nombre', 'pedro', ['boost' => 2.0]);

        $this->toArray()->shouldReturn(
            [
                'prefix' => [
                    'nombre' => [
                        'value' => 'pedro',
                        'boost' => 2.0
                    ]
                ]
            ]
        );
    }

    function it_returns_term_query_as_json_with_params()
    {
        $this->beConstructedWith('nombre', 'pedro', ['boost' => 2.0]);

        $this->toJson()->shouldReturn(
            json_encode([
                'prefix' => [
                    'nombre' => [
                        'value' => 'pedro',
                        'boost' => 2.0
                    ]
                ]
            ])
        );
    }
}
