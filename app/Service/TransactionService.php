<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Service;

use App\Entity\TransactionEntity;
use App\Entity\UserEntity;
use App\Interface\Repository\TransactionRepositoryInterface;
use App\ValueObject\Amount;

class TransactionService
{
    public function __construct(
        private readonly TransactionRepositoryInterface $repository,
    ) {
    }

    public function create(UserEntity $sender, UserEntity $receiver, Amount $amount): TransactionEntity
    {
        return $this->repository->create($sender, $receiver, $amount);
    }
}
