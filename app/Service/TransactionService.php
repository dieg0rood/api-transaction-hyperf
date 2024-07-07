<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\TransactionEntity;
use App\Entity\UserEntity;
use App\Interface\Repository\TransactionRepositoryInterface;
use App\ValueObject\Amount;

class TransactionService
{
    public function __construct(
        private readonly TransactionRepositoryInterface $repository,
    ){}

    public function create(UserEntity $sender, UserEntity $receiver, Amount $amount): TransactionEntity
    {
        return $this->repository->create($sender, $receiver, $amount);
    }

}