<?php
namespace Neokike\LaravelElasticsearchQueryBuilder\Interfaces;

interface QueryInterface
{
    public function toArray();

    public function toJson();
}