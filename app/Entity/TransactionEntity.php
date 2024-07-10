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

readonly class TransactionEntity
{
    public function __construct(
        private string $transactionId,
        private string $senderId,
        private string $receiverId,
        private Amount $value
    ) {
    }
// @codeCoverageIgnoreStart
    public function getId(): string
    {
        return $this->transactionId;
    }
// @codeCoverageIgnoreEnd
    public function getValue(): Amount
    {
        return $this->value;
    }

    public function getReceiverId(): string
    {
        return $this->receiverId;
    }

    public function getSenderId(): string
    {
        return $this->senderId;
    }
}
