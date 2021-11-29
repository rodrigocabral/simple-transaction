<?php

namespace App\Exceptions\Transaction;

use Exception;

class PayerOrPayeeNotFound extends Exception
{
    public function __construct()
    {
        parent::__construct('Payer or Payee are not found.');
    }
}
