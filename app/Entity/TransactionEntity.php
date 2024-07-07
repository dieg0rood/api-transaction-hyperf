<?php

declare(strict_types=1);

namespace App\Entity;

use App\ValueObject\Amount;

readonly class TransactionEntity {
    public function __construct(
        private string $id,
        private string $sender_id,
        private string $receiver_id,
        private Amount $value
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getValue(): Amount
    {
        return $this->value;
    }

    public function getReceiverId(): string
    {
        return $this->receiver_id;
    }

    public function getSenderId(): string
    {
        return $this->sender_id;
    }

}