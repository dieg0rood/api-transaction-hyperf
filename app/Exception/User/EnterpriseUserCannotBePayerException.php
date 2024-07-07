<?php

declare(strict_types=1);

namespace App\Exception\User;

use App\Enum\ExceptionMessagesEnum;
use Hyperf\HttpMessage\Exception\ForbiddenHttpException;

class EnterpriseUserCannotBePayerException extends ForbiddenHttpException
{
    public function __construct()
    {
        parent::__construct(ExceptionMessagesEnum::EnterpriseUserCannotBePayerMessage->value);
    }
}