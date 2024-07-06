<?php

declare(strict_types=1);

namespace App\Exception\Notification;

use App\Enum\ApplicationErrorCodesEnum;
use App\Exception\ApplicationException;

class NotificationRequestException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct(ApplicationErrorCodesEnum::NotificationRequestException);
    }
}