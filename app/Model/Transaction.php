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

class Transaction extends Model
{
    protected ?string $table = 'transactions';

    protected array $fillable = ['id', 'sender_id', 'receiver_id', 'value'];
}
