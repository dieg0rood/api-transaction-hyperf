<?php

declare(strict_types=1);

namespace App\ExternalServices\Interface;

use App\Entity\UserEntity;
use App\ValueObject\Amount;

interface NotificationServiceInterface
{
    public function notifyTransfer(UserEntity $sender, UserEntity $receiver, Amount $amount): void;
}