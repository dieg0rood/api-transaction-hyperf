<?php

declare(strict_types=1);

namespace App\Exception\Auth;

use App\Enum\ExceptionMessagesEnum;
use Hyperf\HttpMessage\Exception\UnauthorizedHttpException;

class TransactionUnauthorizedException extends UnauthorizedHttpException
{
    public function __construct()
    {
        parent::__construct(ExceptionMessagesEnum::TransactionUnauthorizedMessage->value);
    }
}