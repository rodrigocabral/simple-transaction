<?php

namespace App\Rules;

use App\Exceptions\Transaction\InsufficientFunds;
use App\Exceptions\Transaction\MustBeGreaterThenZero;
use App\Exceptions\Transaction\PayerAndPayeeAreTheSame;
use App\Exceptions\Transaction\SellersCantTransferMoney;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IWalletRepository;
use Illuminate\Contracts\Validation\Rule;

class TransactionRule implements Rule
{
    private string $message;
    protected IWalletRepository $walletRepository;
    protected IUserRepository $userRepository;

    public function __construct(
        IWalletRepository $walletRepository,
        IUserRepository $userRepository
    )
    {
        $this->walletRepository = $walletRepository;
        $this->userRepository = $userRepository;
    }

    public function passes($attribute, $value): bool
    {
        $payer = $value['payer'];
        $payee = $value['payee'];
        $value = $value['value'];

        if (empty($value) === true) {
           $this->message = (new MustBeGreaterThenZero())->getMessage();
           return false;
        }

        if ($payer === $payee) {
            $this->message = (new PayerAndPayeeAreTheSame())->getMessage();
            return false;
        }

        if ($this->userRepository->isCommon($payer) === false) {
            $this->message = (new SellersCantTransferMoney())->getMessage();
            return false;
        }

        if ($this->walletRepository->hasFunds($payer, $value) === false) {
            $this->message = (new InsufficientFunds())->getMessage();
            return false;
        }

        return true;
    }

    public function message(): string
    {
        return $this->message;
    }
}
