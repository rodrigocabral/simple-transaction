<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;


class TransactionController extends Controller
{
    public function transactions()
    {
        return Transaction::all();
    }

    public function transaction(Request $request)
    {
        return $request->toArray();
    }

    public function users()
    {
        return User::all();
    }
}
