<?php

namespace App\Services\Notifications;

use App\Services\Contracts\INotificationServiceContract;

class NotificationServiceFake implements INotificationServiceContract
{

    public function execute(array $data): bool
    {
        return true;
    }
}
