<?php
namespace Neokike\LaravelElasticsearchQueryBuilder\Interfaces;

interface SortInterface
{
    public function toArray();

    public function toJson();
}