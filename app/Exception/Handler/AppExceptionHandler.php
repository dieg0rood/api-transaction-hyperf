<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use App\Enum\ApplicationErrorCodesEnum;
use App\Enum\HorusErrorCodesEnum;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Swoole\Http\Status;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    public function __construct(protected StdoutLoggerInterface $logger){}

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->logger->error('Unknow Error');

        $this->logger->error(
            sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile())
        );
        $this->logger->error($throwable->getTraceAsString());

        $this->stopPropagation();

        return $response->withHeader('Server', 'Hyperf')
            ->withStatus(Status::INTERNAL_SERVER_ERROR)
            ->withBody(new SwooleStream(json_encode(['message' => ApplicationErrorCodesEnum::Generic, 'code' => Status::INTERNAL_SERVER_ERROR])));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
