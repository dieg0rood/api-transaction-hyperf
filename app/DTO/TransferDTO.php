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

namespace App\DTO;

use App\Entity\UserEntity;
use App\ValueObject\Amount;

readonly class TransferDTO
{
    public function __construct(
        private UserEntity $sender,
        private UserEntity $receiver,
        private Amount $amount
    ) {
    }

    public function getSender(): UserEntity
    {
        return $this->sender;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getReceiver(): UserEntity
    {
        return $this->receiver;
    }
}
