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

namespace App\ExternalServices\Request\Notification;

use App\ExternalServices\Request\AbstractRequest;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\Contract\StdoutLoggerInterface;
use Swoole\Http\Status;

class NotificationRequest extends AbstractRequest
{
    public const SERVICE_ROUTE = 'notify';

    public function __construct(private StdoutLoggerInterface $logger)
    {
    }

    public function notify($params): void
    {
        try {
            $notify = $this->getClient(config('notify_service_uri'))->post(self::SERVICE_ROUTE, $params);

            if ($notify->getStatusCode() !== Status::NO_CONTENT) {
                $this->logger->error('Cant send notification - payload: ' . json_encode($params));
            }
        } catch (GuzzleException $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
