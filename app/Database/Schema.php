<?php

declare(strict_types=1);

namespace App\Database;

use Hyperf\Database\ConnectionResolverInterface;
use Hyperf\Database\Schema\Schema as DatabaseSchema;
use Hyperf\Context\ApplicationContext;

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
