<?php

declare(strict_types=1);

use App\Interface\Repository\RepositoryInterface;
use App\Interface\Repository\TransactionRepositoryInterface;
use App\Interface\Repository\UserRepositoryInterface;
use App\Interface\Repository\WalletRepositoryInterface;
use App\Repository\Repository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\Repository\WalletRepository;

return [
    UserRepositoryInterface::class          => UserRepository::class,
    WalletRepositoryInterface::class        => WalletRepository::class,
    TransactionRepositoryInterface::class   => TransactionRepository::class,
    RepositoryInterface::class              => Repository::class
];
