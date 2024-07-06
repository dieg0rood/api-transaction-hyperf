<?php

declare(strict_types=1);

namespace App\Repository;

use App\DTO\UserDTO;
use App\Interface\Repository\UserRepositoryInterface;
use App\Model\User;
use Hyperf\DbConnection\Db;


class UserRepository extends Repository implements UserRepositoryInterface
{
    public function __construct(private readonly User $userModel, Db $database)
    {
        parent::__construct($database);
    }

    public function findOrFail(string $userId): ?UserDTO
    {
        $user = $this->userModel->findOrFail($userId)->fresh();

        return UserDTO::create(
            id:         $user->id,
            full_name:  $user->full_name,
            email:      $user->email,
            type:       $user->type
        );
    }
}