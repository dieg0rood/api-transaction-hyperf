<?php

declare(strict_types=1);

namespace App\Entity;

readonly class UserEntity {
    public function __construct(
        private string $id,
        private string $full_name,
        private string $email,
        private string $type
    ) {}

    public function getType(): string
    {
        return $this->type;
    }

    public function getFullName(): string
    {
        return $this->full_name;
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