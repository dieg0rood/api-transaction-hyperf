<?php

declare(strict_types=1);

namespace App\Exception\Wallet;

use App\Enum\ExceptionMessagesEnum;
use Hyperf\HttpMessage\Exception\BadRequestHttpException;

class InsufficientWalletAmountException extends BadRequestHttpException
{
    public function __construct()
    {
        parent::__construct(ExceptionMessagesEnum::InsufficientWalletAmountMessage->value);
    }
}