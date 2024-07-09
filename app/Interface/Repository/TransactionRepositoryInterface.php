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

namespace App\Interface\Repository;

use App\Entity\TransactionEntity;
use App\Entity\UserEntity;
use App\ValueObject\Amount;

interface TransactionRepositoryInterface
{
    public function create(UserEntity $sender, UserEntity $receiver, Amount $amount): TransactionEntity;
}
