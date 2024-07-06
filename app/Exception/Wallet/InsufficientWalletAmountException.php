<?php

declare(strict_types=1);

namespace App\Exception\Wallet;

use App\Enum\ApplicationErrorCodesEnum;
use App\Exception\ApplicationException;
use Swoole\Http\Status;

class InsufficientWalletAmountException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct(ApplicationErrorCodesEnum::InsufficientWalletAmount, Status::UNPROCESSABLE_ENTITY);
    }
}