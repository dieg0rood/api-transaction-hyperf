<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ApplicationExceptionHandler extends ExceptionHandler
{
    public function __construct(protected StdoutLoggerInterface $logger){}

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->logger->error('Application Exception Thrown');
        $this->stopPropagation();
        return $response->withHeader('Server', 'Hyperf')
            ->withStatus($throwable->getCode())
            ->withBody(
                new SwooleStream(json_encode(['message' => $throwable->getMessage(), 'code' => $throwable->getCode()]))
            );
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
