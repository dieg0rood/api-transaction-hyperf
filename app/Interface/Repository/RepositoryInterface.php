<?php

declare(strict_types=1);

namespace App\Interface\Repository;

interface RepositoryInterface
{
    public function beginTransaction(): void;

    public function commit(): void;

    public function rollback(): void;
}