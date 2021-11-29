<?php

namespace App\Exceptions\Transaction;

use Exception;

class PayerAndPayeeAreTheSame extends Exception
{
    public function __construct()
    {
        parent::__construct('You can not transfer money for yourself.');
    }
}
