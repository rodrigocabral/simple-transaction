<?php

namespace App\Repositories\Implementations\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\IUserRepository;

class UserRepository extends BaseRepository implements IUserRepository
{
    protected User $user;
    public const USER_COMMON = 1;
    public const USER_COMPANY = 2;

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function isCommon($id): bool
    {
        $find = $this->find($id);
        return $find->type === self::USER_COMMON;
    }
}
