<?php

namespace Tests\Models;

use Vlmorozov\Finoperations\Models\Account;
use Vlmorozov\Finoperations\Models\AccountCollection;
use Vlmorozov\Finoperations\Models\Balance;
use PHPUnit\Framework\TestCase;
use Vlmorozov\Finoperations\Types\Number;

class AccountCollectionTest extends TestCase
{
    private array $list = [];

    private AccountCollection $accountCollection;

    protected function setUp(): void
    {
        parent::setUp();

        $this->accountCollection = new AccountCollection();
        $this->list = [
            new Account('Name 1', new Balance(new Number(1))),
            new Account('Name 2', new Balance(new Number(2))),
            new Account('Name 3', new Balance(new Number(3))),
        ];
    }

    /**
     * @test
     */
    public function testAdd(): void
    {
        $account = $this->list[0];
        $this->accountCollection->add($account);
        $this->assertSame($account, $this->accountCollection->get(0));
    }

    /**
     * @test
     */
    public function testAddExpectException(): void
    {
        $object = new \stdClass();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument is not Account');

        $this->accountCollection->add($object);
    }

    /**
     * @test
     */
    public function testGet(): void
    {
        $this->accountCollection->add($this->list[0]);
        $this->accountCollection->add($this->list[1]);
        $this->accountCollection->add($this->list[2]);

        $this->assertSame($this->list[1], $this->accountCollection->get(1));
        $this->assertInstanceOf(Account::class, $this->accountCollection->get(1));
    }

    /**
     * @test
     */
    public function testGetAll(): void
    {
        $this->accountCollection->add($this->list[0]);
        $this->accountCollection->add($this->list[1]);
        $this->accountCollection->add($this->list[2]);

        $allTransactions = $this->accountCollection->getAll();

        $this->assertInstanceOf(Account::class, $allTransactions[0]);
        $this->assertCount(3, $allTransactions);
    }

    /**
     * @test
     */
    public function testSort(): void
    {
        $this->accountCollection->add($this->list[1]);
        $this->accountCollection->add($this->list[2]);
        $this->accountCollection->add($this->list[0]);

        $sortedAccounts = $this->accountCollection->sort(
            function (Account $a, Account $b) {
                return $a->getName() <=> $b->getName();
            }
        );

        $this->assertInstanceOf(Account::class, $sortedAccounts[0]);
        $this->assertEquals($this->list[0]->getName(), $sortedAccounts[0]->getName());
        $this->assertCount(3, $sortedAccounts);
    }
}
