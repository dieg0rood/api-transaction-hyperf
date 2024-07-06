<?php

namespace App\Exception\Handler;

use Hyperf\HttpMessage\Stream\SwooleStream;
use \Hyperf\Stringable\Str;
use Hyperf\Validation\ValidationException;
use Hyperf\Validation\ValidationExceptionHandler;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ApplicationValidationExceptionHandler extends ValidationExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        /** @var ValidationException $throwable */
        $fields = $throwable->validator->failed();
        $formattedFields = [];
        foreach ($fields as $key => $field) {
            $formattedFields[$key] = [];
            foreach ($field as $rule => $value) {
                $formattedFields[$key][Str::snake($rule)] = $value;
            }
        }

        if (! $response->hasHeader('content-type')) {
            $response = $response->withAddedHeader('content-type', 'text/plain; charset=utf-8');
        }
        return $response->withStatus($throwable->status)->withBody(new SwooleStream(json_encode($formattedFields)));
    }
}
