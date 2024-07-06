<?php

namespace App\ExternalServices\Request\Notification;

use App\ExternalServices\Request\AbstractRequest;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;

class NotificationRequest extends AbstractRequest
{
    const SERVICE_URI = '54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6';

    public function __construct(private Logger $logger){}

    public function notify($params): void
    {
        try {
            $this->getClient()->get(self::SERVICE_URI, $params);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }
}