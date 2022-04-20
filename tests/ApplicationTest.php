<?php

namespace Tests;

use Vlmorozov\Finoperations\Application;
use PHPUnit\Framework\TestCase;
use Vlmorozov\Finoperations\Models\Account;
use Vlmorozov\Finoperations\Models\Balance;
use Vlmorozov\Finoperations\Models\TransactionType;
use Vlmorozov\Finoperations\Types\Number;

class ApplicationTest extends TestCase
{
    /**
     * @test
     */
    public function testAddAccount(): void
    {
        $account = new Account('name', new Balance(new Number(3)));
        $app = new Application();
        $app->addAccount($account);
        $accounts = $app->getAccounts();

        $this->assertSame($account, $accounts->get(0));
    }

    /**
     * @test
     */
    public function testGetAccounts(): void
    {
        $account1 = new Account('name1', new Balance(new Number(1)));
        $account2 = new Account('name2', new Balance(new Number(2)));
        $account3 = new Account('name3', new Balance(new Number(3)));
        $app = new Application();
        $app->addAccount($account1);
        $app->addAccount($account2);
        $app->addAccount($account3);
        $accounts = $app->getAccounts();

        $this->assertCount(3, $accounts);
        $this->assertInstanceOf(Account::class, $accounts->get(0));
    }

    /**
     * @test
     */
    public function testDeposit(): void
    {
        $comment = 'Comment';
        $amount = new Number(5);
        $account = new Account('name', new Balance(new Number(1)));
        $app = new Application();

        $app->deposit($comment, $amount, $account);

        $this->assertEquals(6, $account->getBalance()->getAmount()->getValue());
        $this->assertCount(1, $account->getBalance()->getTransactions());
        $this->assertEquals(TransactionType::Deposit, $account->getBalance()->getTransactions()->get(0)->getType());
    }

    /**
     * @test
     */
    public function testWithdrawal(): void
    {
        $comment = 'Comment';
        $amount = new Number(5);
        $account = new Account('name', new Balance(new Number(10)));
        $app = new Application();

        $app->withdrawal($comment, $amount, $account);

        $this->assertEquals(5, $account->getBalance()->getAmount()->getValue());
        $this->assertCount(1, $account->getBalance()->getTransactions());
        $this->assertEquals(TransactionType::Withdrawal, $account->getBalance()->getTransactions()->get(0)->getType());
    }

    /**
     * @test
     */
    public function testTransfer(): void
    {
        $comment = 'Comment';
        $amount = new Number(5);
        $accountFrom = new Account('AccountFrom', new Balance(new Number(10)));
        $accountTo = new Account('AccountTo', new Balance(new Number(7)));
        $app = new Application();

        $app->transfer($comment, $amount, $accountFrom, $accountTo);

        $this->assertEquals(5, $accountFrom->getBalance()->getAmount()->getValue());
        $this->assertCount(1, $accountFrom->getBalance()->getTransactions());
        $this->assertEquals(TransactionType::Transfer, $accountFrom->getBalance()->getTransactions()->get(0)->getType());

        $this->assertEquals(12, $accountTo->getBalance()->getAmount()->getValue());
        $this->assertCount(1, $accountTo->getBalance()->getTransactions());
        $this->assertEquals(TransactionType::Transfer, $accountTo->getBalance()->getTransactions()->get(0)->getType());
    }
}
