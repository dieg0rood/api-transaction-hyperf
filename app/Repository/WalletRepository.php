<?php

declare(strict_types=1);

namespace App\Repository;

use App\DTO\WalletDTO;
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

    public function getByUserId(string $userId, $lockForUpdate = false): ?WalletDTO
    {
        $model = $this->walletModel;

        if ($lockForUpdate) {
            $model = $this->walletModel::lockForUpdate();
        }

        $wallet = $model->where('user_id', $userId)->first();

        if(!$wallet) {
            return null;
        }

        return WalletDTO::create(
            id:         $wallet->id,
            user_id:    $wallet->user_id,
            amount:     Amount::fromInteger($wallet->amount)
        );
    }

    public function updateBalance(WalletDTO $wallet, Amount $balance): bool
    {
        $wallet = $this->walletModel->findOrFail($wallet->getId());
        return $wallet->update([
            'amount' => $balance->toInt()
        ]);
    }

}