<?php

declare(strict_types=1);

namespace App\Enum;

enum TransactionNotificationEnum: string
{
    case Send = 'Transfer received from [SENDER] in the amount of R$[AMOUNT]';
    case Receive = 'Transfer sent to [RECEIVER] in the amount of R$[AMOUNT]';

    public function makeMessage(string $userName, string $amount): string
    {
        $message = $this->value;
        $placeholder = $this === self::Send ? '[SENDER]' : '[RECEIVER]';

        $message = str_replace($placeholder, $userName, $message);
        return str_replace('[AMOUNT]', $amount, $message);
    }
}