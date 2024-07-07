<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\TransferRequest;
use App\Resource\TransferResource;
use App\Service\TransferService;
use Psr\Http\Message\ResponseInterface as Response;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Di\Annotation\Inject;
use Swoole\Http\Status;

class TransferController
{
    #[Inject]
    protected TransferService $service;
    #[Inject]
    protected ResponseInterface $response;

    public function transfer (TransferRequest $request): Response
    {
        $transfer = $this->service->handleTransfer(
            $request->getTransactionValue(),
            $request->getSenderId(),
            $request->getReceiverId()
        );

        return TransferResource::make([
            'sender'    => $transfer->getSender(),
            'receiver'  => $transfer->getReceiver(),
            'amount'    => $transfer->getAmount()
        ])->toResponse()
            ->withStatus(Status::CREATED);
    }
}