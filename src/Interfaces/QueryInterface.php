<?php
namespace Neokike\LaravelElasticsearch\Interfaces;

interface QueryInterface
{
    public function toArray();

    public function toJson();
}