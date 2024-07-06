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
            'payer' => $this->sender->id->toString(),
            'payee' => $this->receiver->id->toString(),
        ];

        $response = $this->getData($this->post('/api/transfer', $body));
        var_dump($response);
    }

}
