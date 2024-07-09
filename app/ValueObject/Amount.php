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

namespace App\ValueObject;

use App\Exception\General\InvalidAmountFormatException;

class Amount
{
    private int $amount;

    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    public static function fromDecimal($amount): Amount
    {
        if (! is_float($amount)) {
            throw new InvalidAmountFormatException();
        }
        $amount = round($amount * 100);

        return new Amount((int) $amount);
    }

    public static function fromInteger($amount): Amount
    {
        if (! is_integer($amount)) {
            throw new InvalidAmountFormatException();
        }
        return new Amount($amount);
    }

    public function toInt(): int
    {
        return $this->amount;
    }

    public function toFloat(): float
    {
        return (float) number_format($this->amount / 100, 2, '.', '');
    }

    public function toMoney(): string
    {
        return number_format($this->amount, 2, ',', '.');
    }

    public function subtract(Amount $amount): Amount
    {
        $this->amount -= $amount->toInt();
        return $this;
    }

    public function sum(Amount $amount): Amount
    {
        $this->amount += $amount->toInt();
        return $this;
    }

    public function isNegative(): bool
    {
        return $this->amount < 0;
    }
}
