<?php

declare(strict_types=1);

namespace App\ExternalServices\Request\TransactionAuth;

use App\Exception\ApplicationException;
use App\Exception\Auth\AuthRequestException;
use App\Exception\Auth\TransactionUnauthorizedException;
use App\ExternalServices\Request\AbstractRequest;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\Contract\StdoutLoggerInterface;
use Psr\Http\Message\ResponseInterface;
use function Hyperf\Config\config;

class TransactionAuthRequest extends AbstractRequest
{
    const SERVICE_ROUTE = 'authorize';

    public function __construct(private StdoutLoggerInterface $logger){}

    public function auth(): ResponseInterface|ApplicationException
    {
        try {
            $auth = $this->getClient(config('auth_service_uri'))->get(self::SERVICE_ROUTE);
            $decodedResponse = json_decode($auth->getBody()->getContents(), true);

            if ($decodedResponse['data']['authorization']) {
                return $auth;
            }
            throw new TransactionUnauthorizedException();
        } catch (GuzzleException $e) {
            $this->logger->error($e->getMessage());
            throw new AuthRequestException();
        }
    }
}