<?php

namespace Vlmorozov\Finoperations\Models;

use Vlmorozov\Finoperations\Types\Collection;

class AccountCollection extends Collection
{
    /**
     * @param Account $value
     * @return void
     */
    public function add(mixed $value)
    {
        if (!($value instanceof Account)) {
            throw new \InvalidArgumentException('Argument is not Account');
        }
        parent::add($value);
    }

    /**
     * @param int $index
     * @return Account
     */
    public function get(int $index): Account
    {
        return parent::get($index);
    }

    /**
     * @return Account[]
     */
    public function getAll(): array
    {
        return parent::getAll();
    }
}