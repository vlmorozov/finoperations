<?php

namespace Tests\Models;

use PHPUnit\Framework\TestCase;
use Vlmorozov\Finoperations\Models\Account;
use Vlmorozov\Finoperations\Models\Balance;
use Vlmorozov\Finoperations\Models\OperationWithdrawal;
use Vlmorozov\Finoperations\Models\TransactionType;
use Vlmorozov\Finoperations\Types\Number;

class OperationWithdrawalTest extends TestCase
{
    /**
     * @test
     */
    public function testHandle(): void
    {
        $comment = 'Comment';
        $amount = new Number(5);
        $account = new Account('Account', new Balance(new Number(10)));

        $operation = new OperationWithdrawal($comment, $amount, $account);
        $operation->handle();

        $this->assertEquals(5, $account->getBalance()->getAmount()->getValue());
        $this->assertCount(1, $account->getBalance()->getTransactions());
        $this->assertEquals(TransactionType::Withdrawal, $account->getBalance()->getTransactions()->get(0)->getType());
    }

    /**
     * @test
     */
    public function testConstructorExpectExceptionNegativeAmount(): void
    {
        $amount = new Number(-5);
        $account = new Account('Account', new Balance(new Number(10)));

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Accepted only positive amount');

        new OperationWithdrawal('Comment', $amount, $account);
    }

    /**
     * @test
     */
    public function testConstructorExpectExceptionNotEnoughAmount(): void
    {
        $amount = new Number(15);
        $account = new Account('Account', new Balance(new Number(10)));

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Balance not enough to withdraw');

        new OperationWithdrawal('Comment', $amount, $account);
    }
}
