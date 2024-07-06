<?php

declare(strict_types=1);

namespace App\ExternalServices\Request;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class AbstractRequest
{
    protected ClientInterface $client;
    public function getClient(string $uri)
    {
        return new Client([
            'base_uri' => $uri,
            'timeout' => 5,
            'swoole' => [
                'timeout' => 10,
                'socket_buffer_size' => 1024 * 1024 * 2,
            ],
        ]);
    }
}