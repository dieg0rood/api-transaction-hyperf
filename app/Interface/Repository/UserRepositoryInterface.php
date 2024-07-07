<?php

declare(strict_types=1);

namespace App\Interface\Repository;
use App\Entity\UserEntity;
interface UserRepositoryInterface
{
    public function findOrFail(string $userId): ?UserEntity;
}