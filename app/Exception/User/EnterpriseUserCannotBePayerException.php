<?php

declare(strict_types=1);

namespace App\Exception\User;

use Hyperf\HttpMessage\Exception\ForbiddenHttpException;

class EnterpriseUserCannotBePayerException extends ForbiddenHttpException
{
    public function __construct()
    {
        parent::__construct('Enterprise User Cannot Be Payer');
    }
}