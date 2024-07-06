<?php

declare(strict_types=1);

namespace App\Exception\Wallet;

use Exception;

class InsufficientWalletAmountException extends Exception
{
    public function __construct()
    {
        parent::__construct('Insufficient Wallet Balance');
    }
}