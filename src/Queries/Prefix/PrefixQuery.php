<?php

namespace Neokike\LaravelElasticsearch\Queries\Prefix;

use Neokike\LaravelElasticsearch\Interfaces\QueryInterface;

class PrefixQuery implements QueryInterface
{
    private $field;
    private $value;
    /**
     * @var array
     */
    private $params;

    public function __construct($field, $value, $params = [])
    {

        $this->field = $field;
        $this->value = $value;
        $this->params = $params;
    }

    public function toArray()
    {
        if (count($this->params)) {
            $query = [
                'prefix' => [
                    $this->field => [
                        'value' => $this->value
                    ]
                ]
            ];

            foreach ($this->params as $param => $value) {
                $query['prefix'][$this->field][$param] = $value;
            }

            return $query;
        }

        $query = [
            'prefix' => [$this->field => $this->value]
        ];

        return $query;
    }


    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
