<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Repositories\Contracts\ITransactionRepository;
use App\Services\Contracts\IAuthorizationServiceContract;

class TransactionAuthorization extends Job
{
    protected ITransactionRepository $transactionRepository;
    protected IAuthorizationServiceContract $authorizationService;
    protected Transaction $transaction;

    public function __construct(
        Transaction $transaction,
        IAuthorizationServiceContract $service,
        ITransactionRepository $transactionRepository
    )
    {
        $this->authorizationService = $service;
        $this->transaction = $transaction;
        $this->transactionRepository = $transactionRepository;
    }

    public function handle()
    {
        if ($this->authorizationService->isAuthorized()) {
            $this->transactionRepository->markAsAuthorized($this->transaction->id);
        }
    }
}
