<?php

namespace Neokike\LaravelElasticsearchQueryBuilder\Queries\Bool;

use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\QueryInterface;

class AndQuery extends BooleanQueryAbstract
{

    public $boolType = 'and';

}
