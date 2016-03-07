<?php

namespace Neokike\LaravelElasticsearchQueryBuilder\Queries\Range;

use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\FilterInterface;
use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\QueryInterface;

class RangeQuery implements QueryInterface, FilterInterface
{

    protected $gte;
    protected $gt;
    protected $lte;
    protected $lt;
    protected $format;
    protected $timezone;
    private $field;


    public function __construct($field, $format = null, $timezone = null)
    {

        $this->field = $field;
        $this->format = $format;
        $this->timezone = $timezone;
    }

    /**
     * @param mixed $gte
     * @return RangeQuery
     */
    public function setGreaterThanEqual($gte)
    {
        $this->gte = $gte;
        return $this;
    }

    /**
     * @param mixed $gt
     * @return RangeQuery
     */
    public function setGreaterThan($gt)
    {
        $this->gt = $gt;
        return $this;
    }

    /**
     * @param mixed $lt
     * @return RangeQuery
     */
    public function setLessThan($lt)
    {
        $this->lt = $lt;
        return $this;
    }

    /**
     * @param mixed $lte
     * @return RangeQuery
     */
    public function setLessThanEqual($lte)
    {
        $this->lte = $lte;
        return $this;
    }

    /**
     * @param mixed $format
     * @return RangeQuery
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @param mixed $timezone
     * @return RangeQuery
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
        return $this;
    }


    public function toArray()
    {
        $queryArr = [];

        if ($this->gte) {
            $queryArr['gte'] = $this->gte;
        }

        if ($this->gt) {
            $queryArr['gt'] = $this->gt;
        }

        if ($this->lte) {
            $queryArr['lte'] = $this->lte;
        }

        if ($this->lt) {
            $queryArr['lt'] = $this->lt;
        }

        if ($this->format) {
            $queryArr['format'] = $this->format;
        }

        if ($this->timezone) {
            $queryArr['timezone'] = $this->timezone;
        }

        $query = [
            'range' =>
                [
                    $this->field => $queryArr
                ]
        ];


        return $query;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * get property value
     * @param $propertyName
     * @return $this->$propertyName || null
     */
    public function __get($propertyName)
    {
        if (property_exists($this, $propertyName)) {
            return $this->$propertyName;
        }

        return null;
    }

}
