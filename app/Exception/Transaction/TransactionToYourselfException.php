<?php

declare(strict_types=1);

namespace App\Exception\Transaction;

use Exception;

class TransactionToYourselfException extends Exception
{
    public function __construct()
    {
        parent::__construct('Cannot transfer to yourself');
    }
}