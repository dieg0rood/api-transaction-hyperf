<?php

namespace App\Repository;

use App\DTO\TransactionDTO;
use App\DTO\UserDTO;
use App\Interface\Repository\TransactionRepositoryInterface;
use App\Model\Model;
use App\ValueObject\Amount;
use Hyperf\DbConnection\Db;

class TransactionRepository extends Repository implements TransactionRepositoryInterface
{
    public function __construct(
        private Model $transactionModel, Db $database
    ){
        parent::__construct($database);
    }

    public function create(UserDTO $sender, UserDTO $receiver, Amount $amount): TransactionDTO
    {
        $transaction = $this->transactionModel->create([
            'sender_id' => $sender->getId(),
            'receiver_id' => $receiver->getId(),
            'value' => $amount->toInt()
        ]);
        return TransactionDTO::create(
            id:             $transaction->id,
            sender_id:      $transaction->sender_id,
            receiver_id:    $transaction->receiver_id,
            value:          $transaction->value
        );
    }
}