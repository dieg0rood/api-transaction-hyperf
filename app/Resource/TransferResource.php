<?php

declare(strict_types=1);

namespace App\Resource;

use App\DTO\UserDTO;
use App\ValueObject\Amount;
use Hyperf\Resource\Json\JsonResource;

class TransferResource extends JsonResource
{

    public function toArray(): array
    {
        /** @var UserDTO $sender */
        $sender = $this->resource['sender'];

        /** @var UserDTO $receiver */
        $receiver = $this->resource['receiver'];

        /** @var Amount $amount */
        $amount = $this->resource['amount'];

        return [
            'payer_name'        => $sender->getFullName(),
            'payer_type'        => $sender->getType(),
            'payee_name'        => $receiver->getFullName(),
            'payee_type'        => $receiver->getType(),
            'amount_transfer'   => $amount->toFloat()
        ];
    }

}