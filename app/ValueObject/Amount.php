<?php

namespace App\ValueObject;

use App\Exception\General\InvalidAmountFormatException;

class Amount
{
    private int $amount;

    public function __construct(int $amount) {
        $this->amount = $amount;
    }

    public static function fromDecimal($amount): Amount
    {
        if (!is_float($amount)) {
            throw new InvalidAmountFormatException();
        }
        $amount = $amount * 100;

        return new Amount($amount);
    }

    public static function fromInteger($amount): Amount
    {
        if (!is_integer($amount)) {
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
        return number_format($this->amount, 2, '.', '');
    }

    public function toMoney(): float
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