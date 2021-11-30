<?php

namespace App\Events;

use App\Models\Transaction;
use Illuminate\Queue\SerializesModels;

class TransactionAuthorizedEvent extends Event
{
    use SerializesModels;

    public Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }
}
