<?php

namespace Vlmorozov\Finoperations\Models;

use Vlmorozov\Finoperations\Types\DateInterface;
use Vlmorozov\Finoperations\Types\NumberInterface;

class TransactionFactory
{
    /**
     * @param string $comment
     * @param NumberInterface $amount
     * @param DateInterface $date
     * @return Transaction
     */
    public function createDepositTransaction(
        string          $comment,
        NumberInterface $amount,
        DateInterface   $date
    ): Transaction
    {
        return $this->createTransaction(
            type: TransactionType::Deposit,
            comment: $comment,
            amount: $amount,
            date: $date
        );
    }

    /**
     * @param string $comment
     * @param NumberInterface $amount
     * @param DateInterface $date
     * @return Transaction
     */
    public function createWithdrawalTransaction(
        string          $comment,
        NumberInterface $amount,
        DateInterface   $date
    ): Transaction
    {
        return $this->createTransaction(
            type: TransactionType::Withdrawal,
            comment: $comment,
            amount: $amount,
            date: $date
        );
    }

    /**
     * @param string $comment
     * @param NumberInterface $amount
     * @param Account $relatedAccount
     * @param DateInterface $date
     * @return Transaction
     */
    public function createTransferTransaction(
        string          $comment,
        NumberInterface $amount,
        Account         $relatedAccount,
        DateInterface   $date
    ): Transaction
    {
        return $this->createTransaction(
            type: TransactionType::Transfer,
            comment: $comment,
            amount: $amount,
            date: $date,
            relatedAccount: $relatedAccount
        );
    }

    /**
     * @param TransactionType $type
     * @param string $comment
     * @param NumberInterface $amount
     * @param DateInterface $date
     * @param Account|null $relatedAccount
     * @return Transaction
     */
    private function createTransaction(
        TransactionType $type,
        string          $comment,
        NumberInterface $amount,
        DateInterface   $date,
        ?Account        $relatedAccount = null
    ): Transaction
    {
        return new Transaction($type, $comment, $amount, $date, $relatedAccount);
    }
}