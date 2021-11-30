<?php

namespace App\Services\Contracts;

interface IServiceContract
{
    public function execute(array $data): array;
}
