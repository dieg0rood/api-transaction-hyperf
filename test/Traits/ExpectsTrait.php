<?php

namespace HyperfTest\Traits;

use App\Enum\ApplicationErrorCodesEnum;
use Swoole\Http\Status;

trait ExpectsTrait
{
    public function expectExceptionTest(array $response, ApplicationErrorCodesEnum $expectedErrorCode = ApplicationErrorCodesEnum::Generic, int $expectedStatusCode = Status::INTERNAL_SERVER_ERROR): void
    {
        $this->assertIsArray($response);
        $this->assertArrayHasKey('code', $response);
        $this->assertArrayHasKey('message', $response);
        $this->assertEquals($response['code'], $expectedStatusCode);
        $this->assertEquals($response['message'], $expectedErrorCode->value);
    }
}