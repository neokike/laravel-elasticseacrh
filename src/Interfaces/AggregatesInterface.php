<?php
namespace Neokike\LaravelElasticsearchQueryBuilder\Interfaces;

interface AggregatesInterface
{
    public function toArray();
    public function toJson();
}