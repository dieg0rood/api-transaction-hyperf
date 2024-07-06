<?php

declare(strict_types=1);

namespace App\Exception\General;

use App\Enum\ApplicationErrorCodesEnum;
use App\Exception\ApplicationException;
use Swoole\Http\Status;

class InvalidAmountFormatException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct(ApplicationErrorCodesEnum::EnterpriseUserCannotBePayer, Status::UNPROCESSABLE_ENTITY);
    }
}