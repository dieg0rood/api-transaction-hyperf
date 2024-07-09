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

use App\Entity\UserEntity;
use App\Exception\Wallet\InsufficientWalletAmountException;
use App\Interface\Repository\WalletRepositoryInterface;
use App\ValueObject\Amount;

readonly class WalletService
{
    public function __construct(
        private WalletRepositoryInterface $walletRepository
    ) {
    }

    public function withdraw(UserEntity $user, Amount $amount): bool
    {
        $wallet = $this->walletRepository->getByUserId($user->getId());
        $balance = $wallet->getAmount()->subtract($amount);

        if ($balance->isNegative()) {
            throw new InsufficientWalletAmountException();
        }

        return $this->walletRepository->updateBalance($wallet, $balance);
    }

    public function deposit(UserEntity $user, Amount $amount): bool
    {
        $wallet = $this->walletRepository->getByUserId($user->getId());
        $balance = $wallet->getAmount()->sum($amount);

        return $this->walletRepository->updateBalance($wallet, $balance);
    }
}
