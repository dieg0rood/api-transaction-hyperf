<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\UserEntity;
use App\Exception\Wallet\InsufficientWalletAmountException;
use App\Interface\Repository\WalletRepositoryInterface;
use App\ValueObject\Amount;

readonly class WalletService
{
    public function __construct(
        private WalletRepositoryInterface $walletRepository
    ){}

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