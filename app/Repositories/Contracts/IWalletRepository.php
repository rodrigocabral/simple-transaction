<?php

namespace App\Repositories\Contracts;

interface IWalletRepository
{
    public function hasFunds(int $user_id, float $value = 0): bool;
}
