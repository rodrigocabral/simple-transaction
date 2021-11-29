<?php
namespace Tests\Api;

use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Traits\CreateSimpleWallets;

class TransactionTest extends TestCase
{
    use CreateSimpleWallets;
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createWallets();
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
