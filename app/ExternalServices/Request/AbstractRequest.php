<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

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
