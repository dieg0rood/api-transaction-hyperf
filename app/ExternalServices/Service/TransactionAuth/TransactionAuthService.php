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

namespace App\ExternalServices\Service\TransactionAuth;

use App\ExternalServices\Interface\TransactionAuthServiceInterface;
use App\ExternalServices\Request\TransactionAuth\TransactionAuthRequest;
/**
 * @codeCoverageIgnore
 */
class TransactionAuthService implements TransactionAuthServiceInterface
{
    public function __construct(private TransactionAuthRequest $transactionAuthRequest)
    {
    }

    public function auth(): bool
    {
        return $this->transactionAuthRequest->auth();
    }
}
