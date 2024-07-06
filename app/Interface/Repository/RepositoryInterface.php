<?php

namespace App\Interface\Repository;

interface RepositoryInterface
{
    public function beginTransaction(): void;

    public function commit(): void;

    public function rollback(): void;
}