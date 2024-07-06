<?php

declare(strict_types=1);

namespace App\Resource;

use Hyperf\Resource\Json\JsonResource;

class TransferResource extends JsonResource
{
    public function toArray(): array
    {
        var_dump('resource');
        return [
            'payer'  => $this->sender->getFullName(),
            'payee'  => $this->receiver->getFullName(),
            'amount' => $this->amount->toFloat()
        ];
    }

}