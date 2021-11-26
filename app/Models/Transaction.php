<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['payer', 'payee', 'value'];

    public function payers()
    {
        return $this->hasMany(User::class);
    }

    public function payees()
    {
        return $this->hasMany(User::class);
    }
}
