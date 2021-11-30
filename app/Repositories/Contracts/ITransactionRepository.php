<?php

namespace App\Repositories\Contracts;

interface ITransactionRepository
{
    public function save(array $attributes): object;

    public function markAsNotified(int $transaction_id): bool;

    public function markAsAuthorized(int $transaction_id): bool;

    public function markAsConfirmed(int $transaction_id): void;
}
