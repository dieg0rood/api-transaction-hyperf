<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model as BaseModel;
use Hyperf\Stringable\Str;

abstract class Model extends BaseModel
{
    public bool $incrementing = false;
    public function creating(): void
    {
        if (!$this->id) {
            $this->id = Str::uuid();
        }
    }

}
