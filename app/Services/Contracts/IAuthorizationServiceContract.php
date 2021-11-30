<?php

namespace App\Services\Contracts;

interface IAuthorizationServiceContract
{
    public function isAuthorized(array $data): bool;
}
