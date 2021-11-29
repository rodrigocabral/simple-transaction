<?php

namespace App\Services;

interface IServiceBase
{
    public function execute(array $data): array;
}
