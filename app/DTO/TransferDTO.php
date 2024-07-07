<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\UserEntity;
use App\ValueObject\Amount;

readonly class TransferDTO {
    public function __construct(
        private UserEntity $sender,
        private UserEntity $receiver,
        private Amount     $amount
    ) {}

    public function getSender(): UserEntity
    {
        return $this->sender;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getReceiver(): UserEntity
    {
        return $this->receiver;
    }
}