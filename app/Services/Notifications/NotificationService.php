<?php

namespace App\Services\Notifications;

use App\Repositories\Contracts\ITransactionRepository;
use App\Services\Contracts\INotificationServiceContract;
use Illuminate\Support\Facades\Http;

class NotificationService implements INotificationServiceContract
{
    protected ITransactionRepository $transactionRepository;
    protected string $apiUrl = 'http://o4d9z.mocklab.io/notify';

    public function __construct(
        ITransactionRepository $transactionRepository
    )
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function execute(array $data): bool
    {
        try {
            $response = Http::get($this->apiUrl);
            if ($response['message'] === 'Success') {
                [$transaction_id] = $data;
                $this->transactionRepository->markAsNotified($transaction_id);
            } else {
                return false;
            }
        } catch (\Exception $ex) {
            return false;
        }
        return true;
    }
}
