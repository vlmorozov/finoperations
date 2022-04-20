<?php

namespace Vlmorozov\Finoperations\Models;

use Vlmorozov\Finoperations\Types\NumberInterface;

class Balance
{
    private TransactionCollection $transactions;

    public function __construct(
        private NumberInterface $amount
    )
    {
        $this->transactions = new TransactionCollection();
    }

    /**
     * @return NumberInterface
     */
    public function getAmount(): NumberInterface
    {
        return $this->amount;
    }

    /**
     * @param Transaction $transaction
     * @return void
     */
    public function update(Transaction $transaction): void
    {
        $operationName = $this->getOperationName($transaction->getType());
        $this->amount->$operationName($transaction->getAmount());
        $this->transactions->add($transaction);
    }

    private function getOperationName(TransactionType $type): string
    {
        return match ($type) {
            TransactionType::Deposit, TransactionType::Transfer => 'add',
            TransactionType::Withdrawal => 'sub',
        };
    }

    /**
     * @param Transaction $transaction
     * @return void
     */
    public function decrement(Transaction $transaction): void
    {
        $this->amount->sub($transaction->getAmount());
        $this->transactions->add($transaction);
    }

    /**
     * @return TransactionCollection
     */
    public function getTransactions(): TransactionCollection
    {
        return $this->transactions;
    }
}