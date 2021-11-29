<?php

namespace App\Exceptions\Transaction;

use Exception;

class SellersCantTransferMoney extends Exception
{
    public function __construct()
    {
        parent::__construct('Companies can not transfer money.');
    }
}
