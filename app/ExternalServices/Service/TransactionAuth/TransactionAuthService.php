<?php

declare(strict_types=1);

namespace App\ExternalServices\Service\TransactionAuth;

use App\ExternalServices\Interface\TransactionAuthServiceInterface;
use App\ExternalServices\Request\TransactionAuth\TransactionAuthRequest;

class TransactionAuthService implements TransactionAuthServiceInterface
{
    public function __construct(private TransactionAuthRequest $transactionAuthRequest){}

    public function auth(): bool
    {
        return $this->transactionAuthRequest->auth();
    }
}