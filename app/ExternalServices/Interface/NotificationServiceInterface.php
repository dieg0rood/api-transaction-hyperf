<?php

declare(strict_types=1);

namespace App\ExternalServices\Interface;

use App\DTO\UserDTO;
use App\ValueObject\Amount;

interface NotificationServiceInterface
{
    public function notifyTransfer(UserDTO $sender, UserDTO $receiver, Amount $amount): void;
}