<?php

namespace App\Interface\Repository;

use App\DTO\WalletDTO;
use App\ValueObject\Amount;

interface WalletRepositoryInterface
{
    public function getByUserId(string $userId, $lockForUpdate = false): ?WalletDTO;
    public function updateBalance(WalletDTO $wallet, Amount $balance): bool;
}