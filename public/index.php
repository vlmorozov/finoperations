<?php

use Vlmorozov\Finoperations\Application;
use Vlmorozov\Finoperations\Models\Account;
use Vlmorozov\Finoperations\Models\Balance;
use Vlmorozov\Finoperations\Types\Number;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application();

$account1 = new Account('name1', new Balance(new Number(1)));
$account2 = new Account('name2', new Balance(new Number(2)));
$account3 = new Account('name3', new Balance(new Number(3)));

$app->addAccount($account1);
$app->addAccount($account2);
$app->addAccount($account3);

// get all accounts in the system.
$allAccounts = $app->getAccounts();

var_dump($allAccounts);

// get the balance of a specific account
$balanceSpecificAccount = $app
    ->getAccounts()
    ->get(1)
    ->getBalance()
    ->getAmount()
    ->getValue();
var_dump($balanceSpecificAccount);

// perform an operation
$app->deposit('deposit', new Number(22), $app->getAccounts()->get(1));
$app->withdrawal('withdrawal', new Number(8), $app->getAccounts()->get(1));
$app->transfer('transfer', new Number(3), $app->getAccounts()->get(1), $app->getAccounts()->get(2));

// get all account transactions sorted by comment in alphabetical order.
$accountTransactionsSortedByComment = $app
    ->getAccounts()
    ->get(1)
    ->getBalance()
    ->getTransactions()
    ->getAllSortedByComment();
var_dump($accountTransactionsSortedByComment);

// get all account transactions sorted by date.
$accountTransactionsSortedByDate = $app
    ->getAccounts()
    ->get(1)
    ->getBalance()
    ->getTransactions()
    ->getAllSortedByDate();
var_dump($accountTransactionsSortedByDate);
