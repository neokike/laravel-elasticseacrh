<?php
namespace Neokike\LaravelElasticsearch\Queries\Bool;

use Neokike\LaravelElasticsearch\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearch\Interfaces\QueryInterface;

abstract class BooleanQueryAbstract implements QueryInterface
{
    public $boolType = 'and';

    /**
     * @var
     */
    private $queries;

    public function __construct($queries)
    {
        $this->validateQueries($queries);
        $this->queries = $queries;
    }

    public function toArray()
    {
        $queries = [];
        foreach ($this->queries as $query) {
            array_push($queries, $query->toArray());
        }


        $query = [
            $this->boolType => $queries
        ];

        return $query;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    private function validateQueries($queries)
    {
        if (!is_array($queries)) {
            throw new InvalidArgumentException('it must be an array of elasticsearch queries');
        }

        foreach ($queries as $query) {
            if (!($query instanceof QueryInterface)) {
                throw new InvalidArgumentException('not an elastisearch query');
            }
        }
    }


}