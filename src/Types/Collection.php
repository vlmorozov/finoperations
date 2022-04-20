<?php

namespace Vlmorozov\Finoperations\Types;

abstract class Collection implements \Countable
{
    protected array $data = [];

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function add(mixed $value)
    {
        $this->data[] = $value;
    }

    /**
     * @param int $index
     * @return mixed
     */
    public function get(int $index): mixed
    {
        if (!array_key_exists($index, $this->data)) {
            throw new \InvalidArgumentException("Element with index '{$index}' is not exists");
        }
        return $this->data[$index];
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->data;
    }

    /**
     * @param $compareFunction
     * @return array
     */
    public function sort($compareFunction): array
    {
        if (!is_callable($compareFunction)) {
            throw new \InvalidArgumentException('Invalid compare function');
        }
        $arrayToSort = $this->getAll();
        usort($arrayToSort, $compareFunction);
        return $arrayToSort;
    }


}