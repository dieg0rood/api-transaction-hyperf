<?php

declare(strict_types=1);

namespace App\Entity;

use App\ValueObject\Amount;

readonly class WalletEntity {
    public function __construct(
        private string $id,
        private string $user_id,
        private Amount $amount,
    ) {}

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