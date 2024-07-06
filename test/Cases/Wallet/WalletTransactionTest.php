<?php

declare(strict_types=1);

namespace HyperfTest\Cases\Wallet;

use App\Enum\ApplicationErrorCodesEnum;
use HyperfTest\Cases\AbstractTest;
use HyperfTest\Helpers\Factory\UserGenerator;
use HyperfTest\Traits\AssertsTrait;
use Swoole\Http\Status;

/**
 * @internal
 * @coversNothing
 */
class WalletTransactionTest extends AbstractTest
{
    use AssertsTrait;
    public function testTransactionUserToUser()
    {
        $payerBeforeAmount = 100.00;
        $payeeBeforeAmount = 0.0;
        $transactionAmount = 50.00;

        $payer = UserGenerator::init()->withWallet()->initialAmount($payerBeforeAmount)->create()->toArray();
        $payee = UserGenerator::init()->withWallet()->initialAmount($payeeBeforeAmount)->create()->toArray();

        $body = [
            'value' => $transactionAmount,
            'payer' => $payer['id'],
            'payee' => $payee['id'],
        ];
        $response = $this->getData($this->post('/wallet/transaction', $body));

        $this->validateTransaction($response['data'], $body);
        $this->validateWallet($response['data'], $payerBeforeAmount, $payeeBeforeAmount, $transactionAmount);
    }

    public function testTransactionToYourself()
    {
        $payerBeforeAmount = 100.00;
        $transactionAmount = 50.00;

        $payer = UserGenerator::init()->withWallet()->initialAmount($payerBeforeAmount)->create()->toArray();
        $payee = $payer;

        $body = [
            'value' => $transactionAmount,
            'payer' => $payer['id'],
            'payee' => $payee['id'],
        ];
        $response = $this->getData($this->post('/wallet/transaction', $body));

        $this->expectExceptionTest($response,ApplicationErrorCodesEnum::TransactionToYourselfException, Status::UNPROCESSABLE_ENTITY);
    }

    public function testTransactionWithEnterpriseUserCannotBePayerException()
    {
        $payerBeforeAmount = 100.00;
        $payeeBeforeAmount = 0.0;
        $transactionAmount = 50.00;

        $payer = UserGenerator::init()->withWallet()->enterprise()->initialAmount($payerBeforeAmount)->create()->toArray();
        $payee = UserGenerator::init()->withWallet()->initialAmount($payeeBeforeAmount)->create()->toArray();

        $body = [
            'value' => $transactionAmount,
            'payer' => $payer['id'],
            'payee' => $payee['id'],
        ];
        $response = $this->getData($this->post('/wallet/transaction', $body));

        $this->expectExceptionTest($response,ApplicationErrorCodesEnum::EnterpriseUserCannotBePayer, Status::UNPROCESSABLE_ENTITY);
    }

    public function testTransactionWithInsufficientAmountException()
    {
        $payerBeforeAmount = 100.00;
        $payeeBeforeAmount = 0.0;
        $transactionAmount = 200.00;

        $payer = UserGenerator::init()->withWallet()->initialAmount($payerBeforeAmount)->create()->toArray();
        $payee = UserGenerator::init()->withWallet()->initialAmount($payeeBeforeAmount)->create()->toArray();

        $body = [
            'value' => $transactionAmount,
            'payer' => $payer['id'],
            'payee' => $payee['id'],
        ];
        $response = $this->getData($this->post('/wallet/transaction', $body));

        $this->expectExceptionTest($response,ApplicationErrorCodesEnum::InsufficientWalletAmount, Status::UNPROCESSABLE_ENTITY);
    }
}
