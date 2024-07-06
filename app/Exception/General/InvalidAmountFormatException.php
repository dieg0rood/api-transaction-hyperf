<?php

declare(strict_types=1);

namespace App\Exception\General;

use Exception;

class InvalidAmountFormatException extends Exception
{
    public function __construct()
    {
        parent::__construct('Enterprise User Cannot Be Payer');
    }
}