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

namespace App\ExternalServices\Request\TransactionAuth;

use App\ExternalServices\Request\AbstractRequest;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\Contract\StdoutLoggerInterface;
use Swoole\Http\Status;
/**
 * @codeCoverageIgnore
 */
class TransactionAuthRequest extends AbstractRequest
{
    public const SERVICE_ROUTE = 'authorize';

    public function __construct(private StdoutLoggerInterface $logger)
    {
    }

    public function auth(): bool
    {
        try {
            $auth = $this->getClient(config('auth_service_uri'))->get(self::SERVICE_ROUTE);
            $decodedResponse = json_decode($auth->getBody()->getContents(), true);

            return $decodedResponse['data']['authorization'] && $auth->getStatusCode() === Status::OK;
        } catch (GuzzleException $e) {
            $this->logger->error($e->getMessage());
            return false;
        }
    }
}
