<?php

declare(strict_types=1);

namespace HyperfTest\Cases\Transfer;

use App\Enum\ExceptionMessagesEnum;
use HyperfTest\Cases\AbstractTest;
use Swoole\Http\Status;
use function Swoole\Coroutine\parallel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * @internal
 * @coversNothing
 */
class TransferTest extends AbstractTest
{
    public function testSuccessTransferUserToUserResponse()
    {
        $this->mockTransactionAuthorizedService();

        $this->makePersonalUser(100000, 'sender');
        $this->makePersonalUser(100000, 'receiver');
        $transferAmount = 10.01;

        $body = [
            'value' => $transferAmount,
            'payer' => $this->sender->id->toString(),
            'payee' => $this->receiver->id->toString(),
        ];

        $response = $this->post('/api/transfer', $body);
        $responseBodyContent = json_decode($response->getBody()->getContents());

        $this->assertEquals(Status::CREATED, $response->getStatusCode());

        $this->assertEquals($this->sender->full_name, $responseBodyContent->data->payer_name);
        $this->assertEquals($this->sender->type, $responseBodyContent->data->payer_type);
        $this->assertEquals($this->receiver->full_name, $responseBodyContent->data->payee_name);
        $this->assertEquals($this->receiver->type, $responseBodyContent->data->payee_type);
        $this->assertEquals($transferAmount, $responseBodyContent->data->amount_transfer);
    }

    public function testTransferUnauthorizedWithException()
    {
        $this->mockTransactionAuthorizedService(false);

        $this->makePersonalUser(10000, 'sender');
        $this->makePersonalUser(10000, 'receiver');

        $body = [
            'value' => 10.01,
            'payer' => $this->sender->id->toString(),
            'payee' => $this->receiver->id->toString(),
        ];

        $response = $this->post('/api/transfer', $body);

        $this->expectExceptionTest($response, ExceptionMessagesEnum::TransactionUnauthorizedMessage, Status::UNAUTHORIZED);
    }

    public function testTransferEnterpriseToUserWithException()
    {
        $this->mockTransactionAuthorizedService();

        $this->makeEnterpriseUser(10000, 'sender');
        $this->makePersonalUser(10000, 'receiver');

        $body = [
            'value' => 10.01,
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

        $body = [
            'value' => 9999,
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

        $body = [
            'value' => 10.01,
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

        $body = [
            'value' => 100.00,
            'payer' => $this->sender->id->toString(),
            'payee' => $this->receiver->id->toString(),
        ];

        $response = $this->post('/api/transfer', $body);

        $this->expectExceptionTest($response, ExceptionMessagesEnum::InsufficientWalletAmountMessage, Status::BAD_REQUEST);
    }

    public function testMultipleTransferInSameTime(): void
    {
        $guzzle = new Client([
            'base_uri' => 'http://localhost:9501',
        ]);

        $this->makePersonalUser(1000, 'sender');
        $this->makePersonalUser(1000, 'receiver');

        $body = [
            'value' => 6.00,
            'payer' => $this->sender->id->toString(),
            'payee' => $this->receiver->id->toString(),
        ];

        parallel(4, function() use ($guzzle, $body) {
            try{
                $guzzle->post('/api/transfer', ['json' => $body]);
            } catch (GuzzleException $e){}
        });
        $this->sender->refresh();
        $this->assertEquals(400, $this->sender->wallet()->first()->amount);
    }
}
