<?php

namespace App\Services\Authorizations;

use App\Services\Contracts\IAuthorizationServiceContract;
use Illuminate\Support\Facades\Http;

class AuthorizationService implements IAuthorizationServiceContract
{
    protected string $apiUrl = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

    public function isAuthorized(array $data = []): bool
    {
        try {
            $response = Http::get($this->apiUrl);
            return $response['message'] === 'Success';
        } catch (\Exception $ex) {
            return false;
        }
    }
}
