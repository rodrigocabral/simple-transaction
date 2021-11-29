<?php

namespace App\Repositories\Implementations\Eloquent;

use App\Models\Transaction;
use App\Repositories\Contracts\ITransactionRepository;

class TransactionRepository extends BaseRepository implements ITransactionRepository
{
    protected Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);
    }
}
