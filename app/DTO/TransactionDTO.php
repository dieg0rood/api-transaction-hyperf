<?php

namespace App\DTO;


use App\ValueObject\Amount;

readonly class TransactionDTO {
    private function __construct(
        public string $id,
        public string $sender_id,
        public string $receiver_id,
        public Amount $value
    ) {}

    public static function create(string $id, string $sender_id, string $receiver_id, $value): TransactionDTO {
        return new self($id, $sender_id, $receiver_id, $value);
    }

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