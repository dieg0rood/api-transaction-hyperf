<?php

declare(strict_types=1);

namespace App\Exception\Auth;

use Exception;

class TransactionUnauthorizedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Transaction Unauthorized');
    }
}