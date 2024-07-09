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

namespace App\Repository;

use App\Interface\Repository\RepositoryInterface;
use Hyperf\DbConnection\Db;

class Repository implements RepositoryInterface
{
    public function __construct(private Db $database)
    {
    }

    public function beginTransaction(): void
    {
        $this->database->beginTransaction();
    }

    public function commit(): void
    {
        $this->database->commit();
    }

    public function rollback(): void
    {
        $this->database->rollback();
    }
}
