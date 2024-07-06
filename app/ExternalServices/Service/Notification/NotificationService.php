<?php

declare(strict_types=1);

namespace App\ExternalServices\Service\Notification;

use App\DTO\UserDTO;
use App\Enum\TransactionNotificationEnum;
use App\ExternalServices\Interface\NotificationServiceInterface;
use App\ExternalServices\Request\Notification\NotificationRequest;
use App\ValueObject\Amount;

class NotificationService implements NotificationServiceInterface
{
    public function __construct(private NotificationRequest $request){}

    public function notifyTransfer(UserDTO $sender, UserDTO $receiver, Amount $amount): void
    {
        $messageToSender = TransactionNotificationEnum::Send->makeMessage($receiver->getFullName(), $amount->toMoney());
        $messageToReceiver = TransactionNotificationEnum::Receive->makeMessage($sender->getFullName(), $amount->toMoney());

        $this->notify([
            'message' => $messageToSender,
            'to' => $sender->getEmail()
        ]);

        $this->notify([
            'message' => $messageToReceiver,
            'to' => $receiver->getEmail()
        ]);
    }

    private function notify($params): void
    {
        $this->request->notify($params);
    }
}