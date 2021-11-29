<?php

namespace App\Rules;

use App\Services\AuthorizationService;
use Illuminate\Contracts\Validation\Rule;

class ExternalAuthorizationTransactionRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        $service = app(AuthorizationService::class);

        $result = $service->execute();
        return $result['authorized'];
    }

    public function message(): string
    {
        return 'Transaction is not authorized.';
    }
}
