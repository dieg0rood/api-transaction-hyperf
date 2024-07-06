<?php

namespace App\ExternalServices\Request\TransactionAuth;

use App\Exception\ApplicationException;
use App\Exception\Auth\AuthRequestException;
use App\Exception\Auth\TransactionUnauthorizedException;
use App\ExternalServices\Request\AbstractRequest;
use App\Helper\Logger;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class TransactionAuthRequest extends AbstractRequest
{
    const SERVICE_URI = '5794d450-d2e2-4412-8131-73d0293ac1cc';
    const AUTHORIZED_MESSAGE = 'Autorizado';

    public function auth(): ResponseInterface|ApplicationException
    {
        try {
            $auth = $this->getClient()->get(self::SERVICE_URI);
            $decodedResponse = json_decode($auth->getBody()->getContents(), true);

            if ($decodedResponse['message'] === self::AUTHORIZED_MESSAGE) {
                return $auth;
            }
            throw new TransactionUnauthorizedException();
        } catch (GuzzleException $e) {
            Logger::instanciate()->error($e->getMessage());
            throw new AuthRequestException();
        }
    }
}