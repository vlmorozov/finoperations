<?php

namespace Vlmorozov\Finoperations\Models;

use Vlmorozov\Finoperations\Types\Collection;

class TransactionCollection extends Collection
{
    /**
     * @param Transaction $value
     * @return void
     */
    public function add(mixed $value)
    {
        if (!($value instanceof Transaction)) {
            throw new \InvalidArgumentException('Argument is not Transaction');
        }

        parent::add($value);
    }

    /**
     * @param int $index
     * @return Transaction
     */
    public function get(int $index): Transaction
    {
        return parent::get($index);
    }

    /**
     * @return Transaction[]
     */
    public function getAll(): array
    {
        return parent::getAll();
    }

    /**
     * @param $compareFunction
     * @return Transaction[]
     */
    public function sort($compareFunction): array
    {
        return parent::sort($compareFunction);
    }

    /**
     * @return Transaction[]
     */
    public function getAllSortedByComment(): array
    {
        return $this->sort(function (Transaction $a, Transaction $b) {
            return $a->getComment() <=> $b->getComment();
        });
    }

    /**
     * @return Transaction[]
     */
    public function getAllSortedByDate(): array
    {
        return $this->sort(function (Transaction $a, Transaction $b) {
            return $a->getDate()->compare($b->getDate());
        });
    }
}