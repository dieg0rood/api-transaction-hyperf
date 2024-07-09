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

namespace App\Rule;

use Hyperf\Validation\Contract\Rule;

class AmountRule implements Rule
{
    public function passes(string $attribute, mixed $value): bool
    {
        if ($value <= 0) {
            return false;
        }
        if (! is_numeric($value)) {
            return false;
        }
        $decimalCases = explode('.', (string) $value);
        if (! empty($decimalCases[1]) && strlen($decimalCases[1]) > 2) {
            return false;
        }

        return true;
    }

    public function message(): array|string
    {
        return [
            'en' => 'The value is an invalid float',
        ];
    }
}
