<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\UserEntity;
use App\Exception\Repository\UserDataNotFoundException;
use App\Interface\Repository\UserRepositoryInterface;
use App\Model\User;
use Hyperf\DbConnection\Db;


class UserRepository extends Repository implements UserRepositoryInterface
{
    public function __construct(private readonly User $userModel, Db $database)
    {
        parent::__construct($database);
    }

    public function findOrFail(string $userId): ?UserEntity
    {
        $user = $this->userModel->find($userId);

        if(!$user) {
            throw new UserDataNotFoundException();
        }

        return new UserEntity(
            id:         $user->id,
            fullName:   $user->full_name,
            email:      $user->email,
            type:       $user->type
        );
    }
}