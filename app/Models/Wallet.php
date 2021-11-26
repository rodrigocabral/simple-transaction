<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['balance', 'user_id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}