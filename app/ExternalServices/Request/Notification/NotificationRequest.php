<?php

declare(strict_types=1);

namespace App\ExternalServices\Request\Notification;

use App\ExternalServices\Request\AbstractRequest;
use Hyperf\Contract\StdoutLoggerInterface;
use Swoole\Http\Status;
use function Hyperf\Config\config;

class NotificationRequest extends AbstractRequest
{
    const SERVICE_ROUTE = 'notify';

    public function __construct(private StdoutLoggerInterface $logger){}

    public function notify($params): void
    {
        try {
            $notify = $this->getClient(config('notify_service_uri'))
                ->post(self::SERVICE_ROUTE, $params);

            if ($notify->getStatusCode() !== Status::NO_CONTENT) {
                $this->logger->error('Cant send notification - payload: ' . json_encode($params));
            }
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }
}