<?php

declare(strict_types=1);

namespace App\Exception\Auth;

use App\Enum\ApplicationErrorCodesEnum;
use App\Exception\ApplicationException;
use Swoole\Http\Status;

class TransactionUnauthorizedException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct(ApplicationErrorCodesEnum::TransactionUnauthorizedException, Status::UNAUTHORIZED);
    }
}