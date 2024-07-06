<?php

declare(strict_types=1);

namespace App\Exception\User;

use App\Enum\ApplicationErrorCodesEnum;
use App\Exception\ApplicationException;
use Swoole\Http\Status;

class EnterpriseUserCannotBePayerException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct(ApplicationErrorCodesEnum::EnterpriseUserCannotBePayer, Status::UNPROCESSABLE_ENTITY);
    }
}