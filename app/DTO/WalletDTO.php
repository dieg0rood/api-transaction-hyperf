<?php

declare(strict_types=1);

namespace App\DTO;

use App\ValueObject\Amount;

readonly class WalletDTO {
    private function __construct(
        public string   $id,
        public string   $user_id,
        public Amount   $amount,
    ) {}

    public static function create(string $id, string $user_id, Amount $amount): WalletDTO {
        return new self($id, $user_id, $amount);
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getId(): string
    {
        return $this->id;
    }

}