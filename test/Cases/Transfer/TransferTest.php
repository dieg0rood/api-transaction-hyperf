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
//    public function testSuccessTransferUserToUser()
//    {
//        $this->mockTransactionAuthorizedService();
//
//        $this->makePersonalUser(100000, 'sender');
//        $this->makePersonalUser(100000, 'receiver');
//
//        $body = [
//            'value' => 10.01,
//            'payer' => $this->sender->id->toString(),
//            'payee' => $this->receiver->id->toString(),
//        ];
//
//        $response = $this->getData($this->post('/api/transfer', $body));
//    }

    public function testTransferEnterpriseToUser()
    {
        $this->mockTransactionAuthorizedService();

        $this->makeEnterpriseUser(100000, 'sender');
        $this->makePersonalUser(100000, 'receiver');

        $body = [
            'value' => 10.01,
            'payer' => $this->sender->id->toString(),
            'payee' => $this->receiver->id->toString(),
        ];

        $response = $this->post('/api/transfer', $body);
    }

}
