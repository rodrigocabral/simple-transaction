<?php
namespace Tests\Traits;

use App\Models\User;
use App\Models\Wallet;

trait CreateSimpleWallets
{
    public User $payer;
    public User $payee;
    public user $company;

    private function createWallets(): void
    {
        $this->payer = User::query()->create([
            'name' => 'Common User',
            'document_id' => '79040097062',
            'email' => 'common@app.com',
            'password' => '202cb962ac59075b964b07152d234b70',
            'type' => 1
        ]);

        $this->payee = User::query()->create([
            'name' => 'Second Common User',
            'document_id' => '81127336002',
            'email' => 'common2@app.com',
            'password' => '202cb962ac59075b964b07152d234b70',
            'type' => 1
        ]);

        $this->company = User::query()->create([
            'name' => 'Company User',
            'document_id' => '45738524000112',
            'email' => 'user@company.com',
            'password' => '202cb962ac59075b964b07152d234b70',
            'type' => 2
        ]);

        Wallet::query()->create([
            'user_id' => $this->payer->id,
            'funds' => 100,
        ]);

        Wallet::query()->create([
            'user_id' => $this->payee->id,
        ]);

        Wallet::query()->create([
            'user_id' => $this->company->id,
            'funds' => 400,
        ]);
    }
}
