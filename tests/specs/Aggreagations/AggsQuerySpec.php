<?php

namespace specs\Neokike\LaravelElasticsearchQueryBuilder\Aggreagations;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AggsQuerySpec extends ObjectBehavior
{
    function let(){
        $this->beConstructedWith('agg_name','avg',['field'=>'fieldName']);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearchQueryBuilder\Aggreagations\AggsQuery');
    }

    function it_returns_the_match_query_as_an_array_with_other_params()
    {
        $this->toArray()->shouldReturn(
            [
                'agg_name' =>
                    [
                        'avg' => [
                            'field'            => 'fieldName',
                        ]
                    ]
            ]
        );
    }

    function it_returns_the_match_query_as_a_json()
    {
        $this->toJson()->shouldReturn(
            json_encode([
                'agg_name' =>
                    [
                        'avg' => [
                            'field'            => 'fieldName',
                        ]
                    ]
            ])
        );
    }
}
