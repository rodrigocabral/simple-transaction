<?php

namespace App\Listeners;

use App\Events\TransactionAuthorizedEvent;
use App\Services\Transactions\TransactionService;

class ConfirmTransactionListener
{
    protected TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function handle(TransactionAuthorizedEvent $event): void
    {
        $this->transactionService->confirm(
            [
                $event->transaction->payer,
                $event->transaction->payee,
                $event->transaction->value,
                $event->transaction->id,
            ]
        );
    }
}
