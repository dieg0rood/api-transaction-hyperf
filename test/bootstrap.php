<?php

declare(strict_types=1);

use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\StdoutLoggerInterface;
use Psr\Log\LogLevel;

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');

error_reporting(E_ALL);
date_default_timezone_set('Asia/Shanghai');

! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));
! defined('SWOOLE_HOOK_FLAGS') && define('SWOOLE_HOOK_FLAGS', SWOOLE_HOOK_ALL);

Swoole\Runtime::enableCoroutine(true);

require BASE_PATH . '/vendor/autoload.php';

Hyperf\Di\ClassLoader::init();

$container = require BASE_PATH . '/config/container.php';

$config = $container->get(ConfigInterface::class);

$config->set('databases.default.database', 'testing');

$config->set('logger.default', []);

$config->set(StdoutLoggerInterface::class, [
    'log_level' => [
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::EMERGENCY,
        LogLevel::ERROR,
        LogLevel::INFO,
        LogLevel::NOTICE,
        LogLevel::WARNING,
    ]
]);

$container->get(Hyperf\Contract\ApplicationInterface::class);

Hyperf\Coroutine\run(function () use ($container) {
    $container = Hyperf\Context\ApplicationContext::getContainer();
    $container->get('Hyperf\Database\Commands\Migrations\FreshCommand')->run(
        new Symfony\Component\Console\Input\StringInput(''),
        new Symfony\Component\Console\Output\ConsoleOutput()
    );
});