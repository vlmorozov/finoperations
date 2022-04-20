<?php

namespace Tests\Models;

use Vlmorozov\Finoperations\Models\Account;
use PHPUnit\Framework\TestCase;
use Vlmorozov\Finoperations\Models\Balance;
use Vlmorozov\Finoperations\Types\Number;

class AccountTest extends TestCase
{

    /**
     * @test
     */
    public function testGetName(): void
    {
        $name = 'Name';
        $account = new Account($name, new Balance(new Number(10)));
        $this->assertEquals($name, $account->getName());
    }

    /**
     * @test
     */
    public function testGetBalance(): void
    {
        $balance = new Balance(new Number(10));
        $account = new Account('Name', $balance);
        $this->assertEquals($balance->getAmount()->getValue(), $account->getBalance()->getAmount()->getValue());
        $this->assertSame($balance, $account->getBalance());
    }


}
