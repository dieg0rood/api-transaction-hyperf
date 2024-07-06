<?php

declare(strict_types=1);

namespace App\Model;
class Transaction extends Model
{
    protected ?string $table = 'transactions';
    protected array $fillable = ['id', 'sender_id', 'receiver_id', 'value'];
}
