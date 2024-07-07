<?php

declare(strict_types=1);

namespace App\Exception\Transaction;

use App\Enum\ExceptionMessagesEnum;
use Hyperf\HttpMessage\Exception\BadRequestHttpException;

class TransactionToYourselfException extends BadRequestHttpException
{
    public function __construct()
    {
        parent::__construct(ExceptionMessagesEnum::TransactionToYourselfMessage->value);
    }
}