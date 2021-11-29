<?php

namespace App\Exceptions\Transaction;

use Exception;

class MustBeGreaterThenZero extends Exception
{
    public function __construct()
    {
        parent::__construct('The value must be greater then zero.');
    }
}
