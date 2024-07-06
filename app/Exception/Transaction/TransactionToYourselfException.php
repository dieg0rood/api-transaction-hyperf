<?php

namespace App\Exception\Transaction;

use App\Enum\ApplicationErrorCodesEnum;
use App\Exception\ApplicationException;
use Swoole\Http\Status;

class TransactionToYourselfException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct(ApplicationErrorCodesEnum::TransactionToYourselfException, Status::UNPROCESSABLE_ENTITY);
    }
}