<?php

declare(strict_types=1);

namespace HyperfTest\Cases\Integration;

use App\Enum\ExceptionMessagesEnum;
use App\Enum\UserTypesEnum;
use Hyperf\Stringable\Str;
use HyperfTest\Cases\AbstractTest;
use Swoole\Http\Status;

/**
 * @internal
 * @coversNothing
 */
class TransferTest extends AbstractTest
{
    public function testTransferPersonalUserToPersonalUserSuccess()
    {
        $this->mockTransactionAuthorizedService();

        $initialBalance = 10000;

        $this->makePersonalUser($initialBalance, 'sender');
        $this->makePersonalUser($initialBalance, 'receiver');

        $transferAmount = $this->faker->randomFloat(nbMaxDecimals: 2, max: 100);

        $body = [
            'value' => $transferAmount,
            'payer' => $this->sender->id->toString(),
            'payee' => $this->receiver->id->toString(),
        ];

        $response = $this->post('/api/transfer', $body);
        $responseBodyContent = json_decode($response->getBody()->getContents());

        $this->assertEquals(Status::CREATED, $response->getStatusCode());

        $this->assertEquals($this->sender->full_name, $responseBodyContent->data->payer_name);
        $this->assertEquals(UserTypesEnum::Personal->value, $responseBodyContent->data->payer_type);
        $this->assertEquals($this->receiver->full_name, $responseBodyContent->data->payee_name);
        $this->assertEquals(UserTypesEnum::Personal->value, $responseBodyContent->data->payee_type);
        $this->assertEquals($transferAmount, $responseBodyContent->data->amount_transfer);


        $this->assertEquals($initialBalance - round($transferAmount * 100), $this->sender->wallet()->first()->amount);
        $this->assertEquals($initialBalance + round($transferAmount * 100), $this->receiver->wallet()->first()->amount);
    }

    public function testTransferPersonalUserToEnterpriseUserSuccess()
    {
        $this->mockTransactionAuthorizedService();

        $initialBalance = 10000;

        $this->makePersonalUser($initialBalance, 'sender');
        $this->makeEnterpriseUser($initialBalance, 'receiver');

        $transferAmount = $this->faker->randomFloat(nbMaxDecimals: 2, max: 100);

        $body = [
            'value' => $transferAmount,
            'payer' => $this->sender->id->toString(),
            'payee' => $this->receiver->id->toString(),
        ];

        $response = $this->post('/api/transfer', $body);
        $responseBodyContent = json_decode($response->getBody()->getContents());

        $this->assertEquals(Status::CREATED, $response->getStatusCode());

        $this->assertEquals($this->sender->full_name, $responseBodyContent->data->payer_name);
        $this->assertEquals(UserTypesEnum::Personal->value, $responseBodyContent->data->payer_type);
        $this->assertEquals($this->receiver->full_name, $responseBodyContent->data->payee_name);
        $this->assertEquals(UserTypesEnum::Enterprise->value, $responseBodyContent->data->payee_type);
        $this->assertEquals($transferAmount, $responseBodyContent->data->amount_transfer);

        $this->assertEquals($initialBalance - round($transferAmount * 100), $this->sender->wallet()->first()->amount);
        $this->assertEquals($initialBalance + round($transferAmount * 100), $this->receiver->wallet()->first()->amount);
    }

    public function testTransferEnterpriseToUserWithException()
    {
        $this->mockTransactionAuthorizedService();

        $this->makeEnterpriseUser(10000, 'sender');
        $this->makePersonalUser(10000, 'receiver');

        $transferAmount = $this->faker->randomFloat(nbMaxDecimals: 2, max: 100);

        $body = [
            'value' => $transferAmount,
            'payer' => $this->sender->id->toString(),
            'payee' => $this->receiver->id->toString(),
        ];

        $response = $this->post('/api/transfer', $body);

        $this->expectExceptionTest($response, ExceptionMessagesEnum::EnterpriseUserCannotBePayerMessage, Status::FORBIDDEN);
    }

    public function testInvalidAmountFormatWithException()
    {
        $this->mockTransactionAuthorizedService();

        $this->makePersonalUser(10000, 'sender');
        $this->makePersonalUser(10000, 'receiver');

        $transferAmount = $this->faker->numberBetween(1,10000);

        $body = [
            'value' => $transferAmount,
            'payer' => $this->sender->id->toString(),
            'payee' => $this->receiver->id->toString(),
        ];

        $response = $this->post('/api/transfer', $body);

        $this->expectExceptionTest($response, ExceptionMessagesEnum::InvalidAmountFormatMessage, Status::BAD_REQUEST);
    }

    public function testTransferToYourselfWithException()
    {
        $this->mockTransactionAuthorizedService();

        $this->makePersonalUser(10000, 'sender');
        $this->receiver = $this->sender;
        $transferAmount = $this->faker->randomFloat(nbMaxDecimals: 2, max: 100);

        $body = [
            'value' => $transferAmount,
            'payer' => $this->sender->id->toString(),
            'payee' => $this->receiver->id->toString(),
        ];

        $response = $this->post('/api/transfer', $body);

        $this->expectExceptionTest($response, ExceptionMessagesEnum::TransactionToYourselfMessage, Status::BAD_REQUEST);
    }

    public function testTransferWithInsufficientBalanceException()
    {
        $this->mockTransactionAuthorizedService();

        $this->makePersonalUser(1000, 'sender');
        $this->makePersonalUser(1000, 'receiver');

        $transferAmount = $this->faker->randomFloat(nbMaxDecimals: 2, min: 100);

        $body = [
            'value' => $transferAmount,
            'payer' => $this->sender->id->toString(),
            'payee' => $this->receiver->id->toString(),
        ];

        $response = $this->post('/api/transfer', $body);

        $this->expectExceptionTest($response, ExceptionMessagesEnum::InsufficientWalletAmountMessage, Status::BAD_REQUEST);
    }

    public function testTransferWithNotFoundUserException()
    {
        $this->mockTransactionAuthorizedService();

        $transferAmount = $this->faker->randomFloat(nbMaxDecimals: 2, min: 100);

        $body = [
            'value' => $transferAmount,
            'payer' => Str::uuid()->toString(),
            'payee' => Str::uuid()->toString(),
        ];

        $response = $this->post('/api/transfer', $body);

        $this->expectExceptionTest($response, ExceptionMessagesEnum::UserDataNotFoundMessage, Status::NOT_FOUND);
    }

}
