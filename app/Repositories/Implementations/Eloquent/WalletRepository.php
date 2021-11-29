<?php

namespace App\Repositories\Implementations\Eloquent;

use App\Models\Wallet;
use App\Repositories\Contracts\IWalletRepository;

class WalletRepository extends BaseRepository implements IWalletRepository
{
    protected Wallet $wallet;

    public function __construct(Wallet $wallet)
    {
        parent::__construct($wallet);
    }

    public function hasFunds(int $user_id, float $value = 0): bool
    {
        $find = $this->findOneByColumn('user_id', $user_id);
        return ($value <= $find->funds);
    }
}
