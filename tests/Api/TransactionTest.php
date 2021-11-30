<?php
namespace Tests\Api;

use Illuminate\Support\Facades\Queue;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\CreateSimpleWallets;

class TransactionTest extends TestCase
{
    use CreateSimpleWallets;
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createWallets();
        Queue::fake();
    }

    public function testPostNewTransaction()
    {
        $data = [
            'payer' => $this->payer->id,
            'payee' => $this->payee->id,
            'value' => 50
        ];

        $response = $this->call('POST', '/api/transaction', $data);
        $this->assertEquals(200, $response->status());
        $this->assertEquals($response->getOriginalContent()['message'], 'Success');
    }
}
