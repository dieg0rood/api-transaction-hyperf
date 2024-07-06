<?php

namespace App\Exception;

use App\Enum\ApplicationErrorCodesEnum;
use Hyperf\Server\Exception\ServerException;
use Swoole\Http\Status;
use Throwable;

class ApplicationException extends ServerException
{
    public function __construct(
        ApplicationErrorCodesEnum $message = ApplicationErrorCodesEnum::Generic,
        int $httpCode = Status::INTERNAL_SERVER_ERROR,
        ?Throwable $previous = null
    ) {
        parent::__construct($message->value, $httpCode, $previous);
    }
}