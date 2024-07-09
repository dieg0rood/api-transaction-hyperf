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

use Hyperf\Database\Model\Relations\HasOne;

class User extends Model
{
    protected ?string $table = 'users';

    protected array $fillable = ['id', 'full_name', 'document', 'email', 'type', 'password'];

    public function wallet(): HasOne
    {
        return $this->hasOne(
            Wallet::class
        );
    }
}
