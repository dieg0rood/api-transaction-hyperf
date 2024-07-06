<?php

declare(strict_types=1);

namespace App\ExternalServices\Request\Notification;

use App\ExternalServices\Request\AbstractRequest;
use Hyperf\Contract\StdoutLoggerInterface;

class NotificationRequest extends AbstractRequest
{
    const SERVICE_URI = '54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6';

    const AUTHORIZED_MESSAGE = 'Autorizado';

    public function __construct(private StdoutLoggerInterface $logger){}

    public function notify($params): void
    {
        try {
            $notify = $this->getClient()->get(self::SERVICE_URI, $params);

            $decodedResponse = json_decode($notify->getBody()->getContents(), true);
            if ($decodedResponse['message'] !== self::AUTHORIZED_MESSAGE) {
                $this->logger->error('Unauthorized notification message - payload: ' . json_encode($params));
            }
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }
}