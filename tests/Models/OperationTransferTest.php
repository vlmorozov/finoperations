<?php

namespace Tests\Models;

use PHPUnit\Framework\TestCase;
use Vlmorozov\Finoperations\Models\Account;
use Vlmorozov\Finoperations\Models\Balance;
use Vlmorozov\Finoperations\Models\OperationTransfer;
use Vlmorozov\Finoperations\Models\TransactionType;
use Vlmorozov\Finoperations\Types\Number;

class OperationTransferTest extends TestCase
{

    /**
     * @test
     */
    public function testHandle(): void
    {
        $comment = 'Comment';
        $amount = new Number(5);
        $accountFrom = new Account('AccountFrom', new Balance(new Number(10)));
        $accountTo = new Account('AccountTo', new Balance(new Number(7)));

        $operation = new OperationTransfer($comment, $amount, $accountFrom, $accountTo);
        $operation->handle();

        $this->assertEquals(5, $accountFrom->getBalance()->getAmount()->getValue());
        $this->assertCount(1, $accountFrom->getBalance()->getTransactions());
        $this->assertEquals(TransactionType::Transfer, $accountFrom->getBalance()->getTransactions()->get(0)->getType());

        $this->assertEquals(12, $accountTo->getBalance()->getAmount()->getValue());
        $this->assertCount(1, $accountTo->getBalance()->getTransactions());
        $this->assertEquals(TransactionType::Transfer, $accountTo->getBalance()->getTransactions()->get(0)->getType());
    }

    /**
     * @test
     */
    public function testConstructorExpectExceptionNegativeAmount(): void
    {
        $amount = new Number(-5);
        $accountFrom = new Account('AccountFrom', new Balance(new Number(10)));
        $accountTo = new Account('AccountTo', new Balance(new Number(7)));

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Accepted only positive amount');

        new OperationTransfer('Comment', $amount, $accountFrom, $accountTo);
    }

    /**
     * @test
     */
    public function testConstructorExpectExceptionNotEnoughAmount(): void
    {
        $amount = new Number(15);
        $accountFrom = new Account('AccountFrom', new Balance(new Number(10)));
        $accountTo = new Account('AccountTo', new Balance(new Number(7)));

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Balance not enough to transfer');

        new OperationTransfer('Comment', $amount, $accountFrom, $accountTo);
    }

    /**
     * @test
     */
    public function testConstructorExpectExceptionSameAccount(): void
    {
        $amount = new Number(5);
        $account = new Account('AccountFrom', new Balance(new Number(10)));

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Transfer to same account forbidden');

        new OperationTransfer('Comment', $amount, $account, $account);
    }
}
