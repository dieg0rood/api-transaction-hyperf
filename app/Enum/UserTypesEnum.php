<?php

declare(strict_types=1);

namespace App\Enum;

enum UserTypesEnum: string
{
    case Personal = 'personal';
    case Enterprise = 'enterprise';

    public static function getAllStatusAvailable(): array
    {
        return array_column(UserTypesEnum::cases(), 'value');
    }
}