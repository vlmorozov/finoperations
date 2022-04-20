<?php

namespace Vlmorozov\Finoperations\Models;

class Account
{
    public function __construct(
        private string  $name,
        private Balance $balance,
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Balance
     */
    public function getBalance(): Balance
    {
        return $this->balance;
    }
}