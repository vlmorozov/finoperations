<?php

namespace Vlmorozov\Finoperations\Models;

use Vlmorozov\Finoperations\Types\DateInterface;
use Vlmorozov\Finoperations\Types\NumberInterface;

class Transaction
{
    /**
     * @throws \Exception
     */
    public function __construct(
        private TransactionType $type,
        private string          $comment,
        private NumberInterface $amount,
        private DateInterface   $date,
        private ?Account        $relatedAccount = null
    )
    {
    }

    /**
     * @return TransactionType
     */
    public function getType(): TransactionType
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return NumberInterface
     */
    public function getAmount(): NumberInterface
    {
        return $this->amount;
    }

    /**
     * @return DateInterface
     */
    public function getDate(): DateInterface
    {
        return $this->date;
    }

    /**
     * @return Account|null
     */
    public function getRelatedAccount(): ?Account
    {
        return $this->relatedAccount;
    }

}