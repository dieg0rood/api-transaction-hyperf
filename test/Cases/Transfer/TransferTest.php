<?php

declare(strict_types=1);

namespace HyperfTest\Cases\Transfer;

use HyperfTest\Cases\AbstractTest;
use HyperfTest\Traits\AssertsTrait;


/**
 * @internal
 * @coversNothing
 */
class TransferTest extends AbstractTest
{
    use AssertsTrait;
    public function testSuccessTransactionUserToUser()
    {
        $this->makePersonalUser(10000, 'sender');
        $this->makePersonalUser(10000, 'receiver');

        $body = [
            'value' => 10.00,
            'payer' => $this->sender->id,
            'payee' => $this->receiver->id,
        ];
        var_dump($this->post('/transfer', $body));
        $this->getData($this->post('/transfer', $body));
    }

}
