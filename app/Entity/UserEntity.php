<?php

declare(strict_types=1);

namespace App\Entity;

readonly class UserEntity {
    public function __construct(
        private string $id,
        private string $fullName,
        private string $email,
        private string $type
    ) {}

    public function getType(): string
    {
        return $this->type;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getId(): string
    {
        return $this->id;
    }
}