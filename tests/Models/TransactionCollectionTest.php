<?php

namespace Tests\Models;

use Vlmorozov\Finoperations\Models\Account;
use Vlmorozov\Finoperations\Models\Balance;
use Vlmorozov\Finoperations\Models\Transaction;
use Vlmorozov\Finoperations\Models\TransactionCollection;
use PHPUnit\Framework\TestCase;
use Vlmorozov\Finoperations\Models\TransactionFactory;
use Vlmorozov\Finoperations\Types\Date;
use Vlmorozov\Finoperations\Types\Number;

class TransactionCollectionTest extends TestCase
{
    private array $list = [];

    protected function setUp(): void
    {
        parent::setUp();
        $factory = new TransactionFactory();
        $this->list = [
            $factory->createWithdrawalTransaction(
                comment: 'Comment 1',
                amount: new Number(1),
                date: new Date('2022-04-18 13:00:00')
            ),
            $factory->createWithdrawalTransaction(
                comment: 'Comment 2',
                amount: new Number(2),
                date: new Date('2022-04-18 14:00:00')
            ),
            $factory->createWithdrawalTransaction(
                comment: 'Comment 3',
                amount: new Number(3),
                date: new Date('2022-04-18 15:00:00')
            )
        ];
    }

    /**
     * @test
     */
    public function testCount(): void
    {
        $transactionCollection = new TransactionCollection();
        $transactionCollection->add($this->list[0]);
        $transactionCollection->add($this->list[1]);
        $transactionCollection->add($this->list[2]);


        $this->assertEquals(3, $transactionCollection->count());
    }

    /**
     * @test
     */
    public function testAdd(): void
    {
        $transaction = $this->list[0];

        $transactionCollection = new TransactionCollection();
        $transactionCollection->add($transaction);

        $this->assertSame($transaction, $transactionCollection->get(0));
    }

    /**
     * @test
     */
    public function testAddExpectException(): void
    {
        $account = new Account('name', new Balance(new Number(2)));

        $transactionCollection = new TransactionCollection();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument is not Transaction');
        $transactionCollection->add($account);
    }

    /**
     * @test
     */
    public function testGet(): void
    {
        $transactionCollection = new TransactionCollection();
        $transactionCollection->add($this->list[0]);
        $transactionCollection->add($this->list[1]);
        $transactionCollection->add($this->list[2]);

        $this->assertSame($this->list[1], $transactionCollection->get(1));
        $this->assertInstanceOf(Transaction::class, $transactionCollection->get(1));
    }

    /**
     * @test
     */
    public function testGetAll(): void
    {
        $transactionCollection = new TransactionCollection();
        $transactionCollection->add($this->list[0]);
        $transactionCollection->add($this->list[1]);
        $transactionCollection->add($this->list[2]);

        $allTransactions = $transactionCollection->getAll();

        $this->assertInstanceOf(Transaction::class, $allTransactions[0]);
        $this->assertCount(3, $allTransactions);
    }

    /**
     * @test
     */
    public function testSort(): void
    {
        $transactionCollection = new TransactionCollection();
        $transactionCollection->add($this->list[0]);
        $transactionCollection->add($this->list[1]);
        $transactionCollection->add($this->list[2]);

        $sortedTransactions = $transactionCollection->sort(
            function (Transaction $a, Transaction $b) {
                return $b->getComment() <=> $a->getComment();
            }
        );

        $this->assertInstanceOf(Transaction::class, $sortedTransactions[0]);
        $this->assertEquals($this->list[2]->getComment(), $sortedTransactions[0]->getComment());
        $this->assertCount(3, $sortedTransactions);
    }

    /**
     * @test
     */
    public function testGetAllSortedByComment(): void
    {
        $transactionCollection = new TransactionCollection();
        $transactionCollection->add($this->list[1]);
        $transactionCollection->add($this->list[2]);
        $transactionCollection->add($this->list[0]);

        $sortedTransactions = $transactionCollection->getAllSortedByComment();

        $this->assertInstanceOf(Transaction::class, $sortedTransactions[0]);
        $this->assertEquals($this->list[0]->getComment(), $sortedTransactions[0]->getComment());
        $this->assertCount(3, $sortedTransactions);
    }

    /**
     * @test
     */
    public function testGetAllSortedByDate(): void
    {
        $transactionCollection = new TransactionCollection();
        $transactionCollection->add($this->list[2]);
        $transactionCollection->add($this->list[0]);
        $transactionCollection->add($this->list[1]);

        $sortedTransactions = $transactionCollection->getAllSortedByDate();

        $this->assertInstanceOf(Transaction::class, $sortedTransactions[0]);
        $this->assertEquals($this->list[0]->getDate(), $sortedTransactions[0]->getDate());
        $this->assertCount(3, $sortedTransactions);
    }
}
