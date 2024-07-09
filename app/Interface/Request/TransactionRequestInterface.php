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

namespace App\Interface\Request;

use App\ValueObject\Amount;

interface TransactionRequestInterface
{
    public function getTransactionValue(): Amount;

    public function getSenderId(): string;

    public function getReceiverId(): string;
}
