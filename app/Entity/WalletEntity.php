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

namespace App\Entity;

use App\ValueObject\Amount;

readonly class WalletEntity
{
    public function __construct(
        private string $walletId,
        private string $userId,
        private Amount $amount,
    ) {
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }
// @codeCoverageIgnoreStart
    public function getUserId(): string
    {
        return $this->userId;
    }
// @codeCoverageIgnoreEnd
    public function getId(): string
    {
        return $this->walletId;
    }
}
