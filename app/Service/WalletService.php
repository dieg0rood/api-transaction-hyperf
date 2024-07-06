<?php

namespace App\Service;

use App\DTO\UserDTO;
use App\Exception\Wallet\InsufficientWalletAmountException;
use App\Interface\Repository\WalletRepositoryInterface;
use App\ValueObject\Amount;

class WalletService
{
    const LOCK_FOR_UPDATE = true;
    public function __construct(
        private readonly WalletRepositoryInterface $walletRepository
    )
    {
    }

    public function withdraw(UserDTO $user, Amount $amount): bool
    {
        $wallet = $this->walletRepository->getByUserId($user->getId(), self::LOCK_FOR_UPDATE);
        $balance = $amount->subtract($wallet->getAmount());

        if ($balance->isNegative()) {
            throw new InsufficientWalletAmountException();
        }

        return $this->walletRepository->updateBalance($wallet, $balance);
    }
    public function deposit(UserDTO $user, Amount $amount): bool
    {
        $wallet = $this->walletRepository->getByUserId($user->getId(), self::LOCK_FOR_UPDATE);
        $balance = $amount->sum($wallet->getAmount());

        return $this->walletRepository->updateBalance($wallet, $balance);
    }

}