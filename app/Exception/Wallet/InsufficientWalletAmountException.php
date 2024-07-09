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
