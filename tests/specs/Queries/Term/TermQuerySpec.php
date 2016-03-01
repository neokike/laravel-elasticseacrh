<?php

namespace specs\Neokike\LaravelElasticsearch\Queries\Term;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TermQuerySpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith('user', 'Kymchy');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearch\Queries\Term\TermQuery');
    }

    function it_returns_term_query_as_an_array()
    {
        $this->beConstructedWith('nombre', 'pedro');

        $this->toArray()->shouldReturn(
            [
                'term' => ['nombre' => 'pedro']
            ]
        );
    }

    function it_returns_term_query_as_an_array_with_params()
    {
        $this->beConstructedWith('nombre', 'pedro', ['boost' => 2.0]);

        $this->toArray()->shouldReturn(
            [
                'term' => [
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
                'term' => [
                    'nombre' => [
                        'value' => 'pedro',
                        'boost' => 2.0
                    ]
                ]
            ])
        );
    }
}
