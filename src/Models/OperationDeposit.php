<?php

namespace Vlmorozov\Finoperations\Models;

use Vlmorozov\Finoperations\Types\Date;
use Vlmorozov\Finoperations\Types\NumberInterface;

class OperationDeposit implements OperationInterface
{
    private TransactionFactory $transactionFactory;

    public function __construct(
        private string          $comment,
        private NumberInterface $amount,
        private Account         $account
    )
    {
        if (!$amount->isPositive()) {
            throw new \InvalidArgumentException('Accepted only positive amount');
        }
        $this->transactionFactory = new TransactionFactory();
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $transaction = $this
            ->transactionFactory
            ->createDepositTransaction(
                $this->comment,
                $this->amount,
                Date::getInstance()
            );
        $this->account->getBalance()->update($transaction);
    }
}