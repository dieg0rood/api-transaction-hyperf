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

namespace App\Enum;

enum UserTypesEnum: string
{
    case Personal = 'personal';
    case Enterprise = 'enterprise';


    // @codeCoverageIgnoreStart
    public static function getAllStatusAvailable(): array
    {
        return array_column(UserTypesEnum::cases(), 'value');
    }
    // @codeCoverageIgnoreEnd

}
