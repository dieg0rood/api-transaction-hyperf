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
