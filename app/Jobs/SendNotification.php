<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Services\Contracts\INotificationServiceContract;
use App\Services\Notifications\NotificationService;

class SendNotification extends Job
{
    protected INotificationServiceContract $notificationService;
    protected Transaction $transaction;

    public function __construct(
        Transaction $transaction,
        INotificationServiceContract $service
    )
    {
        $this->notificationService = $service;
        $this->transaction = $transaction;
    }


    public function handle()
    {
        $this->notificationService->execute([$this->transaction->id]);
    }
}
