<?php

namespace App\Repositories\Implementations\Eloquent;

use App\Events\TransactionAuthorizedEvent;
use App\Models\Transaction;
use App\Repositories\Contracts\ITransactionRepository;

class TransactionRepository extends BaseRepository implements ITransactionRepository
{
    public Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);
    }

    public function markAsNotified(int $transaction_id): bool
    {
        return $this->update($transaction_id, [
            'notified' => true
        ]);
    }

    public function markAsConfirmed(int $transaction_id): void
    {
        $this->update($transaction_id, [
            'confirmed' => true
        ]);
    }

    public function markAsAuthorized(int $transaction_id): bool
    {
        $result = $this->update($transaction_id, [
            'authorized' => true
        ]);

        if ($result === false) {
            return false;
        }
        /** @var Transaction $transactionModel */
        $transactionModel = $this->find($transaction_id);
        event(new TransactionAuthorizedEvent($transactionModel));

        return true;
    }
}
