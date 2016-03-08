<?php
namespace Neokike\LaravelElasticsearchQueryBuilder\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class LaravelElasticSearchQueryBuilderServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application.
     */
    public function boot()
    {
        AliasLoader::getInstance()->alias('ElasticQueryBuilder', 'Neokike\LaravelElasticsearchQueryBuilder\Facades\ElasticQueryBuilder');
    }

    /**
     * Register the application.
     */
    public function register()
    {
        $this->app->bind('ElasticQueryBuilder','Neokike\LaravelElasticsearchQueryBuilder\ElasticQueryBuilder');
    }


}