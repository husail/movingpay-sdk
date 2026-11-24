<?php

declare(strict_types=1);

namespace Husail\MovingPay\HttpClient;

use Http\Client\Curl\Client;
use Laminas\Diactoros\StreamFactory;
use Psr\Http\Client\ClientInterface;
use Laminas\Diactoros\ResponseFactory;
use Husail\MovingPay\Configuration\MtlsConfiguration;

final class CurlMtlsClientFactory
{
    public static function create(MtlsConfiguration $configuration): ClientInterface
    {
        return new Client(
            new ResponseFactory(),
            new StreamFactory(),
            [
                CURLOPT_SSLCERT => $configuration->certificatePath,
                CURLOPT_SSLKEY => $configuration->privateKeyPath,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            ] + ($configuration->caBundlePath === null || $configuration->caBundlePath === ''
                ? []
                : [CURLOPT_CAINFO => $configuration->caBundlePath])
        );
    }

    public static function createDefault(): ClientInterface
    {
        return new Client(new ResponseFactory(), new StreamFactory());
    }
}
