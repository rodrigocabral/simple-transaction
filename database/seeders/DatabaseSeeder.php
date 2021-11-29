<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
                'name' => 'Common User',
                'document_id' => '79040097062',
                'email' => 'common@app.com',
                'password' => '202cb962ac59075b964b07152d234b70',
                'type' => 1
            ]);

        User::query()->create([
            'name' => 'Second Common User',
            'document_id' => '81127336002',
            'email' => 'common2@app.com',
            'password' => '202cb962ac59075b964b07152d234b70',
            'type' => 1
        ]);

        User::query()->create([
            'name' => 'Company User',
            'document_id' => '45738524000112',
            'email' => 'user@company.com',
            'password' => '202cb962ac59075b964b07152d234b70',
            'type' => 2
        ]);

        Wallet::query()->create([
            'user_id' => 1,
            'funds' => 100,
        ]);

        Wallet::query()->create([
            'user_id' => 2,
        ]);

        Wallet::query()->create([
            'user_id' => 3,
            'funds' => 400,
        ]);
    }
}
