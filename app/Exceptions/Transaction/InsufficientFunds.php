<?php

namespace App\Exceptions\Transaction;

use Exception;

class InsufficientFunds extends Exception
{
    public function __construct()
    {
        parent::__construct('Insufficient funds.');
    }
}
