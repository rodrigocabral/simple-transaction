<?php

namespace App\Repositories\Contracts;

interface IUserRepository
{
    public function find(int $user_id): object;

    public function isCommon(int $user_id): bool;
}
