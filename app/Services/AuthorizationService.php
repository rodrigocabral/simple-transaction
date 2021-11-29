<?php

namespace App\Services;

use GuzzleHttp\ClientInterface;

class AuthorizationService implements IServiceBase
{
    protected ClientInterface $http;
    protected string $apiUrl = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

    public function __construct(ClientInterface $http)
    {
        $this->http = $http;
    }

    public function execute(array $data = []): array
    {
        $response = json_decode($this->http->request('GET', $this->apiUrl)->getBody()->getContents());
        return ['authorized' => $response->message === 'Autorizado'];
    }
}
