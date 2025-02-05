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

namespace App\Resource;

use App\Entity\UserEntity;
use App\ValueObject\Amount;
use Hyperf\Resource\Json\JsonResource;

class TransferResource extends JsonResource
{
    public function toArray(): array
    {
        /** @var UserEntity $sender */
        $sender = $this->resource['sender'];

        /** @var UserEntity $receiver */
        $receiver = $this->resource['receiver'];

        /** @var Amount $amount */
        $amount = $this->resource['amount'];

        return [
            'payer_name' => $sender->getFullName(),
            'payer_type' => $sender->getType(),
            'payee_name' => $receiver->getFullName(),
            'payee_type' => $receiver->getType(),
            'amount_transfer' => $amount->toFloat(),
        ];
    }
}
