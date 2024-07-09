<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Entity;

readonly class UserEntity
{
    public function __construct(
        private string $userId,
        private string $fullName,
        private string $email,
        private string $type
    ) {
    }

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
        return $this->userId;
    }
}
