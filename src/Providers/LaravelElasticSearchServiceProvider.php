<?php
namespace Neokike\LaravelElasticsearch\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Neokike\LaravelElasticsearch\ElasticQueryBuilder\ElasticQueryBuilder;

class LaravelElasticSearchServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application.
     */
    public function boot()
    {
        AliasLoader::getInstance()->alias('ElasticQueryBuilder', 'Neokike\LaravelElasticsearch\Facades\ElasticQueryBuilder');

    }

    /**
     * Register the application.
     */
    public function register()
    {
        $this->app->bind('ElasticQueryBuilder','Neokike\LaravelElasticsearch\ElasticQueryBuilder');
    }


}