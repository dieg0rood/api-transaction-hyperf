<?php

namespace App\Resource;

use Hyperf\Resource\Json\JsonResource;

class TransferResource extends JsonResource
{
    public function toArray(): array
    {
        return [
            'payer'  => $this->sender->getFullName(),
            'payee'  => $this->receiver->getFullName(),
            'amount' => $this->amount->toFloat()
        ];
    }

}