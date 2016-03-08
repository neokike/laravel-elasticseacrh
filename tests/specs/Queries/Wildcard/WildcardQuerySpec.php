<?php

namespace specs\Neokike\LaravelElasticsearchQueryBuilder\Queries\Wildcard;

use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WildcardQuerySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('user', 'Kyc*hy');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearchQueryBuilder\Queries\Wildcard\WildcardQuery');
    }

    function it_returns_wildcard_query_as_an_array()
    {
        $this->beConstructedWith('nombre', 'ped?ro');

        $this->toArray()->shouldReturn(
            [
                'wildcard' => ['nombre' => 'ped?ro']
            ]
        );
    }

    function it_returns_wildcard_query_as_an_array_with_params()
    {
        $this->beConstructedWith('nombre', 'ped*ro', ['boost' => 2.0]);

        $this->toArray()->shouldReturn(
            [
                'wildcard' => [
                    'nombre' => [
                        'value' => 'ped*ro',
                        'boost' => 2.0
                    ]
                ]
            ]
        );
    }

    function it_returns_wildcard_query_as_json_with_params()
    {
        $this->beConstructedWith('nombre', 'ped*ro', ['boost' => 2.0]);

        $this->toJson()->shouldReturn(
            json_encode([
                'wildcard' => [
                    'nombre' => [
                        'value' => 'ped*ro',
                        'boost' => 2.0
                    ]
                ]
            ])
        );
    }

    function it_throws_exception_if_search_param_is_invalid()
    {
        $this->beConstructedWith('nombre', 'pedro', ['boost' => 2.0]);
        $this->shouldThrow(new InvalidArgumentException('it must have a wildcard item (* or ?)'))->duringInstantiation();
    }
}
