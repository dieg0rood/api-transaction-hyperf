<?php

declare(strict_types=1);

namespace App\Exception\General;

use App\Enum\ExceptionMessagesEnum;
use Hyperf\HttpMessage\Exception\BadRequestHttpException;

class InvalidAmountFormatException extends BadRequestHttpException
{
    public function __construct()
    {
        parent::__construct(ExceptionMessagesEnum::InvalidAmountFormatMessage->value);
    }
}