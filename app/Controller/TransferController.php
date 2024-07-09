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

namespace App\Controller;

use App\Request\TransferRequest;
use App\Resource\TransferResource;
use App\Service\TransferService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Swoole\Http\Status;

class TransferController
{
    #[Inject]
    protected TransferService $service;

    #[Inject]
    protected ResponseInterface $response;

    public function transfer(TransferRequest $request): Response
    {
        $transfer = $this->service->handleTransfer(
            $request->getTransactionValue(),
            $request->getSenderId(),
            $request->getReceiverId()
        );

        return TransferResource::make([
            'sender' => $transfer->getSender(),
            'receiver' => $transfer->getReceiver(),
            'amount' => $transfer->getAmount(),
        ])->toResponse()
            ->withStatus(Status::CREATED);
    }
}
