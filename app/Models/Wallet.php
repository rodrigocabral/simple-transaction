<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['funds', 'user_id'];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }

    public function hasFunds(): bool
    {
        return $this->funds > 0;
    }
}
