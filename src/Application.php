<?php

namespace Vlmorozov\Finoperations;

use Vlmorozov\Finoperations\Models\Account;
use Vlmorozov\Finoperations\Models\AccountCollection;
use Vlmorozov\Finoperations\Models\OperationDeposit;
use Vlmorozov\Finoperations\Models\OperationTransfer;
use Vlmorozov\Finoperations\Models\OperationWithdrawal;
use Vlmorozov\Finoperations\Types\NumberInterface;

class Application
{
    private AccountCollection $accountCollection;

    public function __construct()
    {
        $this->accountCollection = new AccountCollection();
    }

    /**
     * @param Account $account
     * @return void
     */
    public function addAccount(Account $account): void
    {
        $this->accountCollection->add($account);
    }

    /**
     * @return AccountCollection
     */
    public function getAccounts(): AccountCollection
    {
        return $this->accountCollection;
    }

    /**
     * @param string $comment
     * @param NumberInterface $number
     * @param Account $account
     * @return void
     */
    public function deposit(string $comment, NumberInterface $number, Account $account): void
    {
        $operation = new OperationDeposit($comment, $number, $account);
        $operation->handle();
    }

    /**
     * @param string $comment
     * @param NumberInterface $number
     * @param Account $account
     * @return void
     */
    public function withdrawal(string $comment, NumberInterface $number, Account $account): void
    {
        $operation = new OperationWithdrawal($comment, $number, $account);
        $operation->handle();
    }

    /**
     * @param string $comment
     * @param NumberInterface $number
     * @param Account $accountFrom
     * @param Account $accountTo
     * @return void
     */
    public function transfer(string $comment, NumberInterface $number, Account $accountFrom, Account $accountTo): void
    {
        $operation = new OperationTransfer($comment, $number, $accountFrom, $accountTo);
        $operation->handle();
    }

}