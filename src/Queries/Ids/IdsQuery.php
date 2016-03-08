<?php

namespace Neokike\LaravelElasticsearchQueryBuilder\Queries\Ids;

use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\QueryInterface;

class IdsQuery implements QueryInterface
{
    private $type;
    /**
     * @var
     */
    private $ids;

    public function __construct($type, $ids)
    {
        $ids = $this->validateIds($ids);
        $this->type = $type;
        $this->ids = $ids;
    }

    public function toArray()
    {
        $query = [
            "ids" => [
                'type'   => $this->type,
                'values' => $this->ids
            ]
        ];

        return $query;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * @param $ids
     * @return array
     * @throws InvalidArgumentException
     */
    private function validateIds($ids)
    {
        if (is_string($ids)) {
            if (strpos($ids, ',') !== false) {
                $ids = explode(',', $ids);
            } else {
                $ids = [$ids];
            }
        }

        if (is_int($ids))
            $ids = [$ids];

        if (!is_array($ids))
            throw new InvalidArgumentException('it must be an array of ids');
        return $ids;
    }
}
