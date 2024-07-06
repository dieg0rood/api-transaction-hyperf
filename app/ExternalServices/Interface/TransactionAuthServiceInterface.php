<?php

declare(strict_types=1);

namespace App\ExternalServices\Interface;

use App\Exception\ApplicationException;
use Psr\Http\Message\ResponseInterface;

interface TransactionAuthServiceInterface
{
    public function auth(): ApplicationException|ResponseInterface;
}