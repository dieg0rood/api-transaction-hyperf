<?php

declare(strict_types=1);

namespace App\Exception\Repository;

use App\Enum\ExceptionMessagesEnum;
use Hyperf\HttpMessage\Exception\BadRequestHttpException;
use Hyperf\HttpMessage\Exception\NotFoundHttpException;

class WalletDataNotFoundException extends NotFoundHttpException
{
    public function __construct()
    {
        parent::__construct(ExceptionMessagesEnum::WalletDataNotFoundMessage->value);
    }
}