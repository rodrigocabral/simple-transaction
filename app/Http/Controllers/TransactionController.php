<?php

namespace App\Http\Controllers;

use App\Services\Transactions\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

class TransactionController extends BaseController
{
    protected TransactionService $service;

    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function transaction(Request $request)
    {
        $payer_id = $request->get('payer');
        $payee_id = $request->get('payee');
        $value = $request->get('value');

        try {
            $this->service->create([$payer_id, $payee_id, $value]);
        } catch (ValidationException $ex) {

            return response()->json(['error' => $ex->validator->errors()->first()], 400);
        }

        return response()->json(['message' => 'Success']);
    }
}
