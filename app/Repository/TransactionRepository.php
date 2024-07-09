<?php

namespace App\Repository;

use App\Entity\TransactionEntity;
use App\Entity\UserEntity;
use App\Interface\Repository\TransactionRepositoryInterface;
use App\Model\Transaction;
use App\ValueObject\Amount;
use Hyperf\DbConnection\Db;

class TransactionRepository extends Repository implements TransactionRepositoryInterface
{
    public function __construct(private Transaction $transactionModel, Db $database)
    {
        parent::__construct($database);
    }

    public function create(UserEntity $sender, UserEntity $receiver, Amount $amount): TransactionEntity
    {
        $transaction = $this->transactionModel->create([
            'sender_id'     => $sender->getId(),
            'receiver_id'   => $receiver->getId(),
            'value'         => $amount->toInt()
        ]);
        return new TransactionEntity(
            transactionId:  $transaction->id,
            senderId:       $transaction->sender_id,
            receiverId:     $transaction->receiver_id,
            value:          Amount::fromInteger($transaction->value)
        );
    }
}