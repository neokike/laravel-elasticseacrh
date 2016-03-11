<?php

namespace specs\Neokike\LaravelElasticsearchQueryBuilder\Queries\Boosting;

use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\DuplicatedSearchConstraintException;
use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\QueryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BoostingQuerySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(0.2);

    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Neokike\LaravelElasticsearchQueryBuilder\Queries\Boosting\BoostingQuery');
    }

    function it_assign_positive_query(QueryInterface $query)
    {
        $this->setPositive($query)->shouldReturn($this);

        $this->positive->shouldReturn($query);
    }

    function it_assign_negative_query(QueryInterface $query)
    {
        $this->setNegative($query)->shouldReturn($this);

        $this->negative->shouldReturn($query);
    }

    function it_throws_exception_if_negative_query_is_redifined(QueryInterface $query)
    {
        $this->setNegative($query);

        $this->shouldThrow(new DuplicatedSearchConstraintException('negative condition have been already defined'))->duringSetNegative($query);
    }

    function it_throws_exception_if_positive_query_is_redifined(QueryInterface $query)
    {
        $this->setPositive($query);

        $this->shouldThrow(new DuplicatedSearchConstraintException('positive condition have been already defined'))->duringSetPositive($query);
    }

    function it_throws_exception_if_negative_boost_is_not_float()
    {
        $this->beConstructedWith('hola');

        $this->shouldThrow(new InvalidArgumentException('the negative boost must be a float value'))->duringInstantiation();
    }

    function it_returns_the_boosting_query_as_an_array(QueryInterface $positive, QueryInterface $negative)
    {
        $positive->toArray()->willReturn(['field' => 'value']);
        $negative->toArray()->willReturn(['field' => 'value']);

        $this->setPositive($positive);
        $this->setNegative($negative);

        $this->toArray()->shouldReturn(
            [
                'boosting' => [
                    'positive'       => ['field' => 'value'],
                    'negative'       => ['field' => 'value'],
                    'negative_boost' => 0.2,
                ]
            ]
        );
    }

    function it_returns_the_boosting_query_as_json(QueryInterface $positive, QueryInterface $negative)
    {
        $positive->toArray()->willReturn(['field' => 'value']);
        $negative->toArray()->willReturn(['field' => 'value']);

        $this->setPositive($positive);
        $this->setNegative($negative);

        $this->toJson()->shouldReturn(
            json_encode([
                'boosting' => [
                    'positive'       => ['field' => 'value'],
                    'negative'       => ['field' => 'value'],
                    'negative_boost' => 0.2,
                ]
            ])
        );
    }
}
