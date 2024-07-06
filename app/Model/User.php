<?php

declare(strict_types=1);

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
