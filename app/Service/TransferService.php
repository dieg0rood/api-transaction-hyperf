<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\UserDTO;
use App\Enum\UserTypesEnum;
use App\Exception\ApplicationException;
use App\Exception\Auth\AuthRequestException;
use App\Exception\Auth\TransactionUnauthorizedException;
use App\Exception\Transaction\TransactionToYourselfException;
use App\Exception\User\EnterpriseUserCannotBePayerException;
use App\ExternalServices\Service\Notification\NotificationService;
use App\ExternalServices\Service\TransactionAuth\TransactionAuthService;
use App\Interface\Repository\RepositoryInterface;
use App\Repository\UserRepository;
use App\Resource\TransferResource;
use App\ValueObject\Amount;

class TransferService
{
    public function __construct(
        private UserRepository          $userRepository,
        private TransactionAuthService  $authService,
        private RepositoryInterface     $repository,
        private WalletService           $walletService,
        private TransactionService      $transactionService,
        private NotificationService     $notificationService
    ){}

    public function handleTransfer(Amount $amount, string $senderId, string $receiverId): TransferResource
    {
        $this->authService->auth();

        $sender     = $this->userRepository->findOrFail($senderId);
        $receiver   = $this->userRepository->findOrFail($receiverId);

        if ($sender->getType() === UserTypesEnum::Enterprise->value) {
            throw new EnterpriseUserCannotBePayerException();
        }

        if ($receiver->getId() === $sender->getId()) {
            throw new TransactionToYourselfException();
        }

        $this->makeTransfer($sender, $receiver, $amount);
        $this->notificationService->notifyTransfer($sender, $receiver, $amount);

        return TransferResource::make($sender, $receiver, $amount);
    }

    private function makeTransfer(UserDTO $sender, UserDTO $receiver, Amount $amount): void
    {
        try {
            $this->repository->beginTransaction();

            $this->walletService->withdraw($sender, $amount);
            $this->walletService->deposit($receiver, $amount);
            $this->transactionService->create($sender, $receiver, $amount);

            $this->repository->commit();
        } catch (AuthRequestException|TransactionUnauthorizedException $e) {
            $this->repository->rollback();
            throw $e;
        } catch (\Exception $e) {
            $this->repository->rollback();
            throw new ApplicationException();
        }
    }
}