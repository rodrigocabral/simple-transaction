<?php

namespace App\Services\Transactions;

use App\Jobs\TransactionAuthorization;
use App\Repositories\Contracts\ITransactionRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IWalletRepository;
use App\Rules\TransactionRule;
use App\Services\Contracts\IAuthorizationServiceContract;
use App\Services\Contracts\INotificationServiceContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;

class TransactionService
{
    protected ITransactionRepository $transactionRepository;
    protected IUserRepository $userRepository;
    protected IWalletRepository $walletRepository;
    protected INotificationServiceContract $notificationService;
    protected IAuthorizationServiceContract $authorizationService;

    public function __construct(
        ITransactionRepository $transaction,
        IUserRepository $user,
        IWalletRepository $wallet,
        INotificationServiceContract $notificationService,
        IAuthorizationServiceContract $authorizationService
    ) {
        $this->transactionRepository = $transaction;
        $this->userRepository = $user;
        $this->walletRepository = $wallet;
        $this->notificationService = $notificationService;
        $this->authorizationService = $authorizationService;
    }

    public function create(array $data): array
    {

        [$payer_id, $payee_id, $value] = $data;
        $this->validate($payer_id, $payee_id, $value);

        $transaction = $this->transactionRepository->save([
            'payer' => $payer_id,
            'payee' => $payee_id,
            'value' => $value,
            'created_at' => new \DateTimeImmutable(),
            'updated_at' => new \DateTimeImmutable(),
        ]);

        Queue::push(new TransactionAuthorization($transaction, $this->authorizationService, $this->transactionRepository));

        return $transaction->toArray();
    }

    public function confirm(array $data): void
    {
        [$payer_id, $payee_id, $value, $transaction_id] = $data;
        $this->validate($payer_id, $payee_id, $value);

        try {
            DB::beginTransaction();
            $payerWallet = $this->walletRepository->findOneByColumn('user_id', $payer_id);
            $this->walletRepository->update($payerWallet->id, [
                'funds' => $payerWallet->funds - $value
            ]);

            $payeeWallet = $this->walletRepository->findOneByColumn('user_id', $payee_id);
            $this->walletRepository->update($payeeWallet->id, [
                'funds' => $payeeWallet->funds + $value
            ]);
            $this->transactionRepository->markAsConfirmed($transaction_id);
        } catch (\Exception $ex) {
            DB::rollBack();
        }
        DB::commit();
    }

    private function validate(int $payer_id, int $payee_id, float $value): void
    {
        validator(
            ['transaction' => ['payer' => $payer_id, 'payee' => $payee_id, 'value' => $value]],
            ['transaction' =>
                [
                    new TransactionRule($this->walletRepository, $this->userRepository)
                ]
            ]
        )->validate();
    }
}
