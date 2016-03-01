<?php

namespace Neokike\LaravelElasticsearch\Queries\Bool;

use Neokike\LaravelElasticsearch\Interfaces\QueryInterface;

class AndQuery extends BooleanQueryAbstract
{

    public $boolType = 'and';

}
