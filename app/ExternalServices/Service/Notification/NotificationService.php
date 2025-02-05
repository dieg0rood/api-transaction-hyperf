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

namespace App\ExternalServices\Service\Notification;

use App\Entity\UserEntity;
use App\Enum\TransactionNotificationEnum;
use App\ExternalServices\Interface\NotificationServiceInterface;
use App\ExternalServices\Request\Notification\NotificationRequest;
use App\ValueObject\Amount;
/**
 * @codeCoverageIgnore
 */
class NotificationService implements NotificationServiceInterface
{
    public function __construct(private NotificationRequest $request)
    {
    }

    public function notifyTransfer(UserEntity $sender, UserEntity $receiver, Amount $amount): void
    {
        $messageToSender = TransactionNotificationEnum::Send->makeMessage($receiver->getFullName(), $amount->toMoney());
        $messageToReceiver = TransactionNotificationEnum::Receive->makeMessage($sender->getFullName(), $amount->toMoney());

        $this->notify([
            'message' => $messageToSender,
            'to' => $sender->getEmail(),
        ]);

        $this->notify([
            'message' => $messageToReceiver,
            'to' => $receiver->getEmail(),
        ]);
    }

    private function notify($params): void
    {
        $this->request->notify($params);
    }
}
