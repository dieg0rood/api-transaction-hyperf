<?php

namespace HyperfTest\Traits;

use App\Repository\WalletRepository;

trait AssertsTrait
{
    public function validateTransaction($response, $request): void
    {
        $this->assertEquals(($response['value']/100), $request['value']);
        $this->assertEquals($response['sender_id'], $request['payer']);
        $this->assertEquals($response['receiver_id'], $request['payee']);
    }

    public function validateWallet($response, $payerBeforeAmount, $payeeBeforeAmount, $transactionAmount): void
    {
        $senderWallet = WalletRepository::byUser($response['sender_id'])->toArray();
        $receiverWallet = WalletRepository::byUser($response['receiver_id'])->toArray();

        $this->assertEquals(($senderWallet['amount']/100), ($payerBeforeAmount - $transactionAmount));
        $this->assertEquals(($receiverWallet['amount']/100), ($payeeBeforeAmount + $transactionAmount));
    }
}