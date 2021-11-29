<?php

namespace App\Repositories\Contracts;

interface ITransactionRepository
{
    public function save(array $attributes): bool;
}
