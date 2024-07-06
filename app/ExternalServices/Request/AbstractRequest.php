<?php

namespace App\ExternalServices\Request;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Hyperf\Context\ApplicationContext;
use Hyperf\Guzzle\HandlerStackFactory;
use function Hyperf\Config\config;

class AbstractRequest
{
    protected ClientInterface $client;
    protected string $baseUri;
    protected string $contentType = 'application/json';
    private int $timeoutInSeconds = 15;
    public function getClient()
    {
        $this->baseUri = config('service_mock_base_uri');
        $swooleConfig = [
            'timeout' => $this->timeoutInSeconds,
            'socket_buffer_size' => 1024 * 1024 * 2,
        ];

        $container = ApplicationContext::getContainer();
        $stack = $container->get(HandlerStackFactory::class)->create();
        return make(
            Client::class,
            [
                [
                    'handler' => $stack,
                    'base_uri' => $this->baseUri,
                    'headers' => [
                        'Accept' => $this->contentType,
                        'Content-Type' => $this->contentType
                    ],
                    'timeout' => $this->timeoutInSeconds,
                    'swoole' => $swooleConfig,
                ]
            ]
        );
    }
}