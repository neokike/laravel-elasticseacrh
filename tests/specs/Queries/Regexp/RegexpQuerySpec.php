<?php

namespace specs\Neokike\LaravelElasticsearch\Queries\Regexp;

use Neokike\LaravelElasticsearch\Exceptions\InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RegexpQuerySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('user', '/^def/');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearch\Queries\Regexp\RegexpQuery');
    }

    function it_returns_regexp_query_as_an_array()
    {
        $this->beConstructedWith('nombre', '/^def/');

        $this->toArray()->shouldReturn(
            [
                'regexp' => ['nombre' => '/^def/']
            ]
        );
    }

    function it_returns_regexp_query_as_an_array_with_params()
    {
        $this->beConstructedWith('nombre', '/^def/', ['boost' => 2.0]);

        $this->toArray()->shouldReturn(
            [
                'regexp' => [
                    'nombre' => [
                        'value' => '/^def/',
                        'boost' => 2.0
                    ]
                ]
            ]
        );
    }

    function it_returns_regexp_query_as_json_with_params()
    {
        $this->beConstructedWith('nombre', '/^def/', ['boost' => 2.0]);

        $this->toJson()->shouldReturn(
            json_encode([
                'regexp' => [
                    'nombre' => [
                        'value' => '/^def/',
                        'boost' => 2.0
                    ]
                ]
            ])
        );
    }

    function it_throws_exception_if_search_param_is_invalid()
    {
        $this->beConstructedWith('nombre', 'pedro', ['boost' => 2.0]);
        $this->shouldThrow(new InvalidArgumentException('it must be a valid regexp'))->duringInstantiation();
    }
}

