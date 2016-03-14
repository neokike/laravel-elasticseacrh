<?php
namespace Neokike\LaravelElasticsearchQueryBuilder\Sort;

use Neokike\LaravelElasticsearchQueryBuilder\Exceptions\InvalidArgumentException;
use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\FilterInterface;
use Neokike\LaravelElasticsearchQueryBuilder\Interfaces\SortInterface;

class SortQuery implements SortInterface
{
    protected $field;
    protected $mode;
    protected $order;
    protected $nested_path;
    protected $nested_filter;
    protected $meta = [];

    public function __construct($field)
    {

        $this->field = $field;
    }

    /**
     * @param mixed $mode
     * @return SortQuery
     */
    public function mode($mode)
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @param mixed $order
     * @return SortQuery
     */
    public function order($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @param mixed $nested_path
     * @return SortQuery
     */
    public function nestedPath($nested_path)
    {
        $this->nested_path = $nested_path;
        return $this;
    }

    /**
     * @param mixed $nested_filter
     * @return SortQuery
     */
    public function nestedFilter($nested_filter)
    {
        if (!($nested_filter instanceof FilterInterface))
            throw new InvalidArgumentException('it must a filter object');

        $this->nested_filter = $nested_filter;
        return $this;
    }

    public function toArray()
    {

        $sortArray = [];

        if ($this->mode)
            $sortArray['mode'] = $this->mode;

        if ($this->order)
            $sortArray['order'] = $this->order;

        if ($this->nested_path)
            $sortArray['nested_path'] = $this->nested_path;

        if ($this->nested_filter)
            $sortArray['nested_filter'] = $this->nested_filter->toArray();

        if (count($this->meta)) {
            foreach ($this->meta as $param => $value) {
                $sortArray[$param] = $value;
            }
        }

        if (count($sortArray)) {
            $query = [
                $this->field => $sortArray
            ];
        } else {
            $query = $this->field;
        }


        return $query;
    }


    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * @param mixed $field
     * @return SortQuery
     */
    public function field($field)
    {
        $this->field = $field;
        return $this;
    }

    public function param($param, $value)
    {
        $this->meta[$param] = $value;
        return $this;
    }
}