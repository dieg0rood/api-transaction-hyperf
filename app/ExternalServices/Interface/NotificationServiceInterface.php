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

namespace App\ExternalServices\Interface;

use App\Entity\UserEntity;
use App\ValueObject\Amount;

interface NotificationServiceInterface
{
    public function notifyTransfer(UserEntity $sender, UserEntity $receiver, Amount $amount): void;
}
