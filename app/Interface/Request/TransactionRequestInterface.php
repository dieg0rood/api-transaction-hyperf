<?php

declare(strict_types=1);

namespace App\Interface\Request;

use App\ValueObject\Amount;

interface TransactionRequestInterface
{
    public function getTransactionValue(): Amount;
    public function getSenderId(): string;
    public function getReceiverId(): string;
}