<?php

namespace Tests\Feature\Services;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Repositories\Implementations\Eloquent\TransactionRepository;
use App\Repositories\Implementations\Eloquent\UserRepository;
use App\Repositories\Implementations\Eloquent\WalletRepository;
use App\Services\Authorizations\AuthorizationServiceFake;
use App\Services\Notifications\NotificationServiceFake;
use App\Services\Transactions\TransactionService;
use Illuminate\Support\Facades\Queue;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\CreateSimpleWallets;

class TransactionServiceTest extends TestCase
{

    use DatabaseMigrations;
    use CreateSimpleWallets;

    private TransactionService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new TransactionService(
            new TransactionRepository(new Transaction()),
            new UserRepository(new User()),
            new WalletRepository(new Wallet()),
            new NotificationServiceFake(),
            new AuthorizationServiceFake()
        );
        $this->createWallets();
        Queue::fake();
    }

    public function testTransaction(): void
    {
        $value = 50;
        $result = $this->service->create([$this->payer->id, $this->company->id, $value]);
        $this->assertIsArray($result);
        $this->seeInDatabase('transactions', ['id' => $result['id']]);
    }

    public function testInsuficientFunds(): void
    {
        $this->expectException(ValidationException::class);
        $value = 200;
        $this->service->create([$this->payer->id, $this->payee->id, $value]);
    }

    public function testCompanyCantTransferMoney(): void
    {
        $this->expectException(ValidationException::class);
        $value = 200;
        $this->service->create([$this->company->id, $this->payee->id, $value]);
    }

    public function testPayerAndPayeeCantBeTheSame(): void
    {
        $this->expectException(ValidationException::class);
        $value = 200;
        $this->service->create([$this->payer->id, $this->payer->id, $value]);
    }
}
