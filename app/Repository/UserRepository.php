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

        if (! $user) {
            throw new UserDataNotFoundException();
        }

        return new UserEntity(
            userId: $user->id,
            fullName: $user->full_name,
            email: $user->email,
            type: $user->type
        );
    }
}
