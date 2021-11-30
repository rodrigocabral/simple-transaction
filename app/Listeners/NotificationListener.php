<?php

namespace App\Listeners;

use App\Events\TransactionAuthorizedEvent;
use App\Jobs\SendNotification;
use App\Services\Contracts\INotificationServiceContract;
use Illuminate\Support\Facades\Queue;

class NotificationListener
{
    protected INotificationServiceContract $notificationService;
    public function __construct(INotificationServiceContract $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(TransactionAuthorizedEvent $event)
    {
        Queue::push(new SendNotification($event->transaction, $this->notificationService));
    }
}
