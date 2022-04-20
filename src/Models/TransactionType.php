<?php

namespace Vlmorozov\Finoperations\Models;

enum TransactionType
{
    case Deposit;
    case Withdrawal;
    case Transfer;
}