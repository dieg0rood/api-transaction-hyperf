<?php

namespace App\ExternalServices\Service\TransactionAuth;

use App\ExternalServices\Request\TransactionAuth\TransactionAuthRequest;

class TransactionAuthService
{
    public function __construct(private TransactionAuthRequest $transactionAuthRequest)
    {
    }

    public function auth()
    {
        return $this->transactionAuthRequest->auth();
    }
}