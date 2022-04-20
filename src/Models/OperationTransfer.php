<?php

namespace Vlmorozov\Finoperations\Models;

use Vlmorozov\Finoperations\Types\Date;
use Vlmorozov\Finoperations\Types\NumberInterface;

class OperationTransfer implements OperationInterface
{
    private TransactionFactory $transactionFactory;

    public function __construct(
        private string          $comment,
        private NumberInterface $amount,
        private Account         $accountFrom,
        private Account         $accountTo,
    )
    {
        if (!$amount->isPositive()) {
            throw new \InvalidArgumentException('Accepted only positive amount');
        }
        if ($this->accountFrom->getBalance()->getAmount()->lt($amount)) {
            throw new \InvalidArgumentException('Balance not enough to transfer');
        }
        if ($accountFrom === $accountTo) {
            throw new \InvalidArgumentException('Transfer to same account forbidden');
        }
        $this->transactionFactory = new TransactionFactory();
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $creditAmount = clone $this->amount;
        $creditAmount->inverseSign();

        $date = Date::getInstance();

        $transactionFrom = $this
            ->transactionFactory
            ->createTransferTransaction(
                comment: $this->comment,
                amount: $creditAmount,
                relatedAccount: $this->accountTo,
                date: $date,
            );
        $transactionTo = $this
            ->transactionFactory
            ->createTransferTransaction(
                comment: $this->comment,
                amount: $this->amount,
                relatedAccount: $this->accountFrom,
                date: $date,
            );

        $this->accountFrom->getBalance()->update($transactionFrom);
        $this->accountTo->getBalance()->update($transactionTo);
    }
}