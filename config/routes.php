<?php

declare(strict_types=1);

use App\Controller\TransferController;
use Hyperf\HttpServer\Router\Router;

Router::post('/transfer', [TransferController::class, 'transfer']);

