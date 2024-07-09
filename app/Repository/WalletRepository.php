<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\WalletEntity;
use App\Exception\Repository\WalletDataNotFoundException;
use App\Interface\Repository\WalletRepositoryInterface;
use App\Model\Wallet;
use App\ValueObject\Amount;
use Hyperf\DbConnection\Db;

class WalletRepository extends Repository implements WalletRepositoryInterface
{
    public function __construct(private Wallet $walletModel, Db $database)
    {
        parent::__construct($database);
    }

    public function getByUserId(string $userId): WalletEntity
    {
        $wallet = $this->walletModel::lockForUpdate()->where('user_id', $userId)->first();

        if(!$wallet) {
            throw new WalletDataNotFoundException();
        }

        return new WalletEntity(
            walletId:   $wallet->id,
            userId:     $wallet->user_id,
            amount:     Amount::fromInteger($wallet->amount)
        );
    }

    public function updateBalance(WalletEntity $wallet, Amount $balance): bool
    {
        $wallet = $this->walletModel->findOrFail($wallet->getId());
        return $wallet->update([
            'amount' => $balance->toInt()
        ]);
    }

}