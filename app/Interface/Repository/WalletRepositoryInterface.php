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

use App\Entity\WalletEntity;
use App\ValueObject\Amount;

interface WalletRepositoryInterface
{
    public function getByUserId(string $userId): WalletEntity;

    public function updateBalance(WalletEntity $wallet, Amount $balance): bool;
}
