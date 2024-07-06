<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\Database\Model\Relations\BelongsTo;

class Wallet extends Model
{
    protected ?string $table = 'wallets';
    protected array $fillable = ['id', 'user_id', 'amount'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }
}
