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

namespace App\Service;

use App\DTO\TransferDTO;
use App\Entity\UserEntity;
use App\Enum\UserTypesEnum;
use App\Exception\Auth\TransactionUnauthorizedException;
use App\Exception\Transaction\TransactionToYourselfException;
use App\Exception\User\EnterpriseUserCannotBePayerException;
use App\Exception\Wallet\InsufficientWalletAmountException;
use App\ExternalServices\Interface\NotificationServiceInterface;
use App\ExternalServices\Interface\TransactionAuthServiceInterface;
use App\Interface\Repository\RepositoryInterface;
use App\Repository\UserRepository;
use App\ValueObject\Amount;
use Exception;

class TransferService
{
    public function __construct(
        private UserRepository $userRepository,
        private TransactionAuthServiceInterface $authService,
        private RepositoryInterface $repository,
        private WalletService $walletService,
        private TransactionService $transactionService,
        private NotificationServiceInterface $notificationService
    ) {
    }

    public function handleTransfer(Amount $amount, string $senderId, string $receiverId): TransferDTO
    {
        $sender = $this->userRepository->findOrFail($senderId);
        $receiver = $this->userRepository->findOrFail($receiverId);

        if ($sender->getType() === UserTypesEnum::Enterprise->value) {
            throw new EnterpriseUserCannotBePayerException();
        }

        if ($receiver->getId() === $sender->getId()) {
            throw new TransactionToYourselfException();
        }

        $this->makeTransfer($sender, $receiver, $amount);
        $this->notificationService->notifyTransfer($sender, $receiver, $amount);

        return new TransferDTO(
            sender: $sender,
            receiver: $receiver,
            amount: $amount
        );
    }

    private function makeTransfer(UserEntity $sender, UserEntity $receiver, Amount $amount): void
    {
        try {
            $this->repository->beginTransaction();

            $this->walletService->withdraw($sender, $amount);
            $this->walletService->deposit($receiver, $amount);

            $this->transactionService->create($sender, $receiver, $amount);

            if (! $this->authService->auth()) {
                throw new TransactionUnauthorizedException();
            }

            $this->repository->commit();
        } catch (Exception|InsufficientWalletAmountException|TransactionUnauthorizedException $e) {
            $this->repository->rollback();
            throw $e;
        }
    }
}
