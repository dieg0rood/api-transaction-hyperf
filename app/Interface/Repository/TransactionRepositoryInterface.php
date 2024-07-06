<?php

declare(strict_types=1);

namespace App\Interface\Repository;

use App\DTO\TransactionDTO;
use App\DTO\UserDTO;
use App\ValueObject\Amount;

interface TransactionRepositoryInterface
{
    public function create(UserDTO $sender, UserDTO $receiver, Amount $amount): TransactionDTO;
}