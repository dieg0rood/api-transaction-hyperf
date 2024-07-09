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

namespace App\Database;

use Hyperf\Context\ApplicationContext;
use Hyperf\Database\ConnectionResolverInterface;
use Hyperf\Database\Schema\Schema as DatabaseSchema;

class Schema extends DatabaseSchema
{
    public static function __callStatic($name, $arguments)
    {
        $container = ApplicationContext::getContainer();
        $resolver = $container->get(ConnectionResolverInterface::class);
        $connection = $resolver->connection();
        return $connection->getSchemaBuilder()->{$name}(...$arguments);
    }
}
