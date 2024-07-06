<?php

namespace App\Interface\Request;

use App\ValueObject\Amount;

interface TransactionRequestInterface
{
    public function getTransactionValue(): Amount;
    public function getSenderId(): string;
    public function getReceiverId(): string;
}