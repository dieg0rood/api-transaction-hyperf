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
use App\ExternalServices\Interface\NotificationServiceInterface;
use App\ExternalServices\Interface\TransactionAuthServiceInterface;
use App\ExternalServices\Service\Notification\NotificationService;
use App\ExternalServices\Service\TransactionAuth\TransactionAuthService;
use App\Interface\Repository\RepositoryInterface;
use App\Interface\Repository\TransactionRepositoryInterface;
use App\Interface\Repository\UserRepositoryInterface;
use App\Interface\Repository\WalletRepositoryInterface;
use App\Repository\Repository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\Repository\WalletRepository;

return [
    UserRepositoryInterface::class => UserRepository::class,
    WalletRepositoryInterface::class => WalletRepository::class,
    TransactionRepositoryInterface::class => TransactionRepository::class,
    RepositoryInterface::class => Repository::class,
    TransactionAuthServiceInterface::class => TransactionAuthService::class,
    NotificationServiceInterface::class => NotificationService::class,
];
