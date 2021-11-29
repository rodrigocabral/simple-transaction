<?php

namespace Tests\Feature\Services;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Repositories\Implementations\Eloquent\TransactionRepository;
use App\Repositories\Implementations\Eloquent\UserRepository;
use App\Repositories\Implementations\Eloquent\WalletRepository;
use App\Services\TransactionService;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Traits\CreateSimpleWallets;

class TransactionServiceTest extends TestCase
{
    use DatabaseTransactions;
    use CreateSimpleWallets;

    private TransactionService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new TransactionService(
            new TransactionRepository(new Transaction()),
            new UserRepository(new User()),
            new WalletRepository(new Wallet())
        );
        $this->createWallets();
    }

    public function testTransaction(): void
    {
        $value = 50;
        $result = $this->service->execute([$this->payer->id, $this->company->id, $value]);
        $this->assertIsArray($result);
        $this->seeInDatabase('transactions', $result);
    }

    public function testInsuficientFunds(): void
    {
        $this->expectException(ValidationException::class);
        $value = 200;
        $this->service->execute([$this->payer->id, $this->payee->id, $value]);
    }

    public function testCompanyCantTransferMoney(): void
    {
        $this->expectException(ValidationException::class);
        $value = 200;
        $this->service->execute([$this->company->id, $this->payee->id, $value]);
    }

    public function testPayerAndPayeeCantBeTheSame(): void
    {
        $this->expectException(ValidationException::class);
        $value = 200;
        $this->service->execute([$this->payer->id, $this->payer->id, $value]);
    }
}
