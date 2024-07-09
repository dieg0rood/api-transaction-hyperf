<?php

declare(strict_types=1);

namespace App\Interface\Repository;

use App\Entity\WalletEntity;
use App\ValueObject\Amount;

interface WalletRepositoryInterface
{
    public function getByUserId(string $userId): WalletEntity;
    public function updateBalance(WalletEntity $wallet, Amount $balance): bool;
}