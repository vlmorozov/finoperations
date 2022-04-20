<?php

namespace Tests\Models;

use PHPUnit\Framework\TestCase;
use Vlmorozov\Finoperations\Models\Account;
use Vlmorozov\Finoperations\Models\Balance;
use Vlmorozov\Finoperations\Models\OperationDeposit;
use Vlmorozov\Finoperations\Models\TransactionType;
use Vlmorozov\Finoperations\Types\Number;

class OperationDepositTest extends TestCase
{

    /**
     * @test
     */
    public function testHandle(): void
    {
        $comment = 'Comment';
        $amount = new Number(5);
        $account = new Account('Account', new Balance(new Number(10)));

        $operation = new OperationDeposit($comment, $amount, $account);
        $operation->handle();

        $this->assertEquals(15, $account->getBalance()->getAmount()->getValue());
        $this->assertCount(1, $account->getBalance()->getTransactions());
        $this->assertEquals(TransactionType::Deposit, $account->getBalance()->getTransactions()->get(0)->getType());
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

        new OperationDeposit('Comment', $amount, $account);
    }

}
