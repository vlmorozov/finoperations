<?php

namespace Tests\Models;

use Vlmorozov\Finoperations\Models\Account;
use Vlmorozov\Finoperations\Models\Balance;
use Vlmorozov\Finoperations\Models\Transaction;
use Vlmorozov\Finoperations\Models\TransactionFactory;
use PHPUnit\Framework\TestCase;
use Vlmorozov\Finoperations\Models\TransactionType;
use Vlmorozov\Finoperations\Types\Date;
use Vlmorozov\Finoperations\Types\Number;

final class TransactionFactoryTest extends TestCase
{
    private TransactionFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new TransactionFactory();
    }

    /**
     * @test
     */
    public function testCreateWithdrawalTransaction(): void
    {
        $comment = 'Comment Withdrawal';
        $amount = new Number(3);
        $date = Date::getInstance();

        $transaction = $this->factory->createWithdrawalTransaction($comment, $amount, $date);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertSame(TransactionType::Withdrawal, $transaction->getType());
        $this->assertSame($comment, $transaction->getComment());
        $this->assertSame($amount, $transaction->getAmount());
        $this->assertSame($date, $transaction->getDate());
    }

    /**
     * @test
     */
    public function testCreateDepositTransaction(): void
    {
        $comment = 'Comment Deposit';
        $amount = new Number(4);
        $date = Date::getInstance();

        $transaction = $this->factory->createDepositTransaction($comment, $amount, $date);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertSame(TransactionType::Deposit, $transaction->getType());
        $this->assertSame($comment, $transaction->getComment());
        $this->assertSame($amount, $transaction->getAmount());
        $this->assertSame($date, $transaction->getDate());
    }

    /**
     * @test
     */
    public function testCreateTransferTransaction(): void
    {
        $comment = 'Comment Transfer';
        $amount = new Number(5);
        $account = new Account('name', new Balance(new Number(10)));
        $date = Date::getInstance();

        $transaction = $this->factory->createTransferTransaction($comment, $amount, $account, $date);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertSame(TransactionType::Transfer, $transaction->getType());
        $this->assertSame($comment, $transaction->getComment());
        $this->assertSame($amount, $transaction->getAmount());
        $this->assertSame($account, $transaction->getRelatedAccount());
        $this->assertSame($date, $transaction->getDate());
    }
}
