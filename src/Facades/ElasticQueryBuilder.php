<?php
namespace Neokike\LaravelElasticsearchQueryBuilder\Facades;

use Illuminate\Support\Facades\Facade;

class ElasticQueryBuilder extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'ElasticQueryBuilder';
    }
}