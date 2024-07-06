<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\TransactionDTO;
use App\DTO\UserDTO;
use App\Interface\Repository\TransactionRepositoryInterface;
use App\ValueObject\Amount;

class TransactionService
{
    public function __construct(
        private readonly TransactionRepositoryInterface $repository,
    ){}

    public function create(UserDTO $sender, UserDTO $receiver, Amount $amount): TransactionDTO
    {
        return $this->repository->create($sender, $receiver, $amount);
    }

}