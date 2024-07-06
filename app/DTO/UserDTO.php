<?php

declare(strict_types=1);

namespace App\DTO;

readonly class UserDTO {
    private function __construct(
        public string $id,
        public string $full_name,
        public string $email,
        public string $type
    ) {}

    public static function create(string $id, string $full_name, string $email, $type): UserDTO {
        return new self($id, $full_name, $email, $type);
    }

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