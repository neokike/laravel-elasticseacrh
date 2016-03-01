<?php

namespace Neokike\LaravelElasticsearch\Queries\Regexp;

use Neokike\LaravelElasticsearch\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearch\Interfaces\QueryInterface;

class RegexpQuery implements QueryInterface
{
    private $field;
    private $search;
    /**
     * @var array
     */
    private $params;

    public function __construct($field, $regexp, $params = [])
    {
        $this->validateRegexp($regexp);
        $this->field = $field;
        $this->regexp = $regexp;
        $this->params = $params;
    }

    public function toArray()
    {
        if (count($this->params)) {
            $query = [
                'regexp' => [
                    $this->field => [
                        'value' => $this->regexp
                    ]
                ]
            ];

            foreach ($this->params as $param => $value) {
                $query['regexp'][$this->field][$param] = $value;
            }

            return $query;
        }

        $query = [
            'regexp' => [$this->field => $this->regexp]
        ];

        return $query;
    }


    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * @param $regexp
     * @throws InvalidArgumentException
     */
    private function validateRegexp($regexp)
    {
        if (@preg_match($regexp, "Lorem ipsum") === false) {
            throw new InvalidArgumentException('it must be a valid regexp');

        }
    }
}
