<?php

declare(strict_types=1);

namespace App\Interface\Repository;

use App\Entity\TransactionEntity;
use App\Entity\UserEntity;
use App\ValueObject\Amount;

interface TransactionRepositoryInterface
{
    public function create(UserEntity $sender, UserEntity $receiver, Amount $amount): TransactionEntity;
}