<?php

namespace App\Services\Contracts;

interface INotificationServiceContract
{
    public function execute(array $data): bool;
}
