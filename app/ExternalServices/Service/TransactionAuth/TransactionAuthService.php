<?php

declare(strict_types=1);

namespace App\ExternalServices\Service\TransactionAuth;

use App\Exception\ApplicationException;
use App\ExternalServices\Interface\TransactionAuthServiceInterface;
use App\ExternalServices\Request\TransactionAuth\TransactionAuthRequest;
use Psr\Http\Message\ResponseInterface;

class TransactionAuthService implements TransactionAuthServiceInterface
{
    public function __construct(private TransactionAuthRequest $transactionAuthRequest){}

    public function auth(): ApplicationException|ResponseInterface
    {
        return $this->transactionAuthRequest->auth();
    }
}