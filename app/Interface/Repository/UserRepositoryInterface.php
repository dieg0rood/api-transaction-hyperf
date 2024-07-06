<?php

namespace App\Interface\Repository;
use App\DTO\UserDTO;
interface UserRepositoryInterface
{
    public function findOrFail(string $userId): ?UserDTO;
}