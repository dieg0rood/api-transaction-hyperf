<?php

declare(strict_types=1);

namespace App\Entity;

use App\ValueObject\Amount;

readonly class TransactionEntity {
    public function __construct(
        private string $id,
        private string $senderId,
        private string $receiverId,
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
        return $this->receiverId;
    }

    public function getSenderId(): string
    {
        return $this->senderId;
    }

}