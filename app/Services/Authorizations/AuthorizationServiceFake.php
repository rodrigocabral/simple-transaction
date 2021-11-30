<?php

namespace App\Services\Authorizations;

use App\Services\Contracts\IAuthorizationServiceContract;

class AuthorizationServiceFake implements IAuthorizationServiceContract
{
    public function isAuthorized(array $data = []): bool
    {
        return true;
    }
}
