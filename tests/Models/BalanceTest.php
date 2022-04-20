<?php

namespace Models;

use Vlmorozov\Finoperations\Models\Balance;
use PHPUnit\Framework\TestCase;
use Vlmorozov\Finoperations\Models\TransactionFactory;
use Vlmorozov\Finoperations\Types\Date;
use Vlmorozov\Finoperations\Types\Number;

class BalanceTest extends TestCase
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
    public function testUpdateDeposit(): void
    {
        $balance = new Balance(new Number(10));
        $transaction = $this->factory->createDepositTransaction('Comment', new Number(4), Date::getInstance());
        $balance->update($transaction);
        $this->assertEquals(14, $balance->getAmount()->getValue());
        $this->assertCount(1, $balance->getTransactions());
    }

    /**
     * @test
     */
    public function testUpdateWithdrawal(): void
    {
        $balance = new Balance(new Number(10));
        $transaction = $this->factory->createWithdrawalTransaction('Comment', new Number(3), Date::getInstance());
        $balance->decrement($transaction);
        $this->assertEquals(7, $balance->getAmount()->getValue());
        $this->assertCount(1, $balance->getTransactions());
    }

    /**
     * @test
     */
    public function testGetAmount(): void
    {
        $balance = new Balance(new Number(10));
        $this->assertEquals(10, $balance->getAmount()->getValue());
    }

    /**
     * @test
     */
    public function testGetTransactions(): void
    {
        $balance = new Balance(new Number(10));
        $transaction = $this->factory->createDepositTransaction('Comment', new Number(4), Date::getInstance());
        $balance->update($transaction);
        $this->assertCount(1, $balance->getTransactions());
        $this->assertSame($transaction, $balance->getTransactions()->get(0));
    }
}
