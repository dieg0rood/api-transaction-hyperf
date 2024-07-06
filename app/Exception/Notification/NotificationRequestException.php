<?php

declare(strict_types=1);

namespace App\Exception\Notification;

use Exception;

class NotificationRequestException extends Exception
{
    public function __construct()
    {
        parent::__construct('Error to send notification');
    }
}