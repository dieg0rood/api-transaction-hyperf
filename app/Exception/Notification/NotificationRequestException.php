<?php

declare(strict_types=1);

namespace App\Exception\Notification;

use App\Enum\ExceptionMessagesEnum;
use Hyperf\HttpMessage\Exception\BadRequestHttpException;

class NotificationRequestException extends BadRequestHttpException
{
    public function __construct()
    {
        parent::__construct(ExceptionMessagesEnum::NotificationRequestMessage->value);
    }
}