<?php

namespace App\Services;

use App\Repositories\Contracts\ITransactionRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IWalletRepository;
use App\Rules\ExternalAuthorizationTransactionRule;
use App\Rules\TransactionRule;

class TransactionService implements IServiceBase
{
    protected ITransactionRepository $transactionRepository;
    protected IUserRepository $userRepository;
    protected IWalletRepository $walletRepository;

    public function __construct(
        ITransactionRepository $transaction,
        IUserRepository $user,
        IWalletRepository $wallet
    ) {
        $this->transactionRepository = $transaction;
        $this->userRepository = $user;
        $this->walletRepository = $wallet;
    }

    public function execute(array $data): array
    {
        [$payer_id, $payee_id, $value] = $data;

        $this->validate($payer_id, $payee_id, $value);
        $payerWallet = $this->walletRepository->findOneByColumn('user_id', $payer_id);
        $this->walletRepository->update($payerWallet->id,[
            'funds' => $payerWallet->funds - $value
        ]);

        $payeeWallet = $this->walletRepository->findOneByColumn('user_id', $payee_id);
        $this->walletRepository->update($payeeWallet->id,[
            'funds' => $payeeWallet->funds + $value
        ]);

        $transactionData = [
            'payer' => $payer_id,
            'payee' => $payee_id,
            'value' => $value,
            'created_at' => new \DateTimeImmutable(),
            'updated_at' => new \DateTimeImmutable(),
        ];

        $this->transactionRepository->save($transactionData);

        return $transactionData;
    }

    private function validate(int $payer_id, int $payee_id, float $value): void
    {
        validator(
            ['transaction' => ['payer' => $payer_id, 'payee' => $payee_id, 'value' => $value]],
            ['transaction' =>
                [
                    new TransactionRule($this->walletRepository, $this->userRepository),
                    new ExternalAuthorizationTransactionRule()
                ]
            ]
        )->validate();
    }
}
