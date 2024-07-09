<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Exception\Auth;

use App\Enum\ExceptionMessagesEnum;
use Hyperf\HttpMessage\Exception\UnauthorizedHttpException;

class TransactionUnauthorizedException extends UnauthorizedHttpException
{
    public function __construct()
    {
        parent::__construct(ExceptionMessagesEnum::TransactionUnauthorizedMessage->value);
    }
}
