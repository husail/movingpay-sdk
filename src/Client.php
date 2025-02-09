<?php

declare(strict_types=1);

/*
 * This file is part of the MovingPay SDK.
 *
 * (c) Victor Danilo <victordanilo_cs@live.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Husail\MovingPay;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\UriInterface;
use Husail\MovingPay\HttpClient\Builder;
use Http\Discovery\Psr17FactoryDiscovery;
use Husail\MovingPay\Apis\Estabelecimento;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Husail\MovingPay\HttpClient\HttpMethodsClient;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Husail\MovingPay\HttpClient\Plugin\LoggerPlugin;
use Husail\MovingPay\HttpClient\Plugin\AuthenticationPlugin;
use Husail\MovingPay\Contracts\Http\Message\FormatterInterface;
use Husail\MovingPay\HttpClient\Message\Formatter\SimpleFormatter;

final class Client
{
    public const PACKAGE_NAME = 'MovingPay';
    public const USER_AGENT = 'movingpay-php-sdk/1.0';
    public const BASE_URI = 'https://api.movingpay.com.br/api/v3';

    private Builder $httpClientBuilder;
    public readonly Estabelecimento $estabelecimento;

    public function __construct(?Authentication $authentication = null, ?Builder $httpClientBuilder = null, ?LoggerInterface $logger = null, ?FormatterInterface $formatter = null)
    {
        $this->httpClientBuilder = $httpClientBuilder ?? new Builder();
        $this->httpClientBuilder->addPlugin(new BaseUriPlugin($this->factoryBaseUri()));
        $this->httpClientBuilder->addPlugin(
            new HeaderDefaultsPlugin(
                [
                    'User-Agent' => Client::USER_AGENT,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ]
            )
        );

        if (!empty($authentication)) {
            $this->httpClientBuilder->addPlugin(new AuthenticationPlugin($authentication));
        }
        if (!empty($logger)) {
            $this->httpClientBuilder->addPlugin(new LoggerPlugin(Client::PACKAGE_NAME, $logger, $formatter ?? new SimpleFormatter()));
        }

        $this->estabelecimento = new Estabelecimento($this->getHttpClient());
    }

    private function factoryBaseUri(): UriInterface
    {
        return Psr17FactoryDiscovery::findUriFactory()->createUri(Client::BASE_URI);
    }

    public function getHttpClient(): HttpMethodsClient
    {
        return $this->httpClientBuilder->getHttpClient();
    }

    public function authenticate(Authentication $authentication): void
    {
        $this->httpClientBuilder->removePlugin(Authentication::class);
        $this->httpClientBuilder->addPlugin(new AuthenticationPlugin($authentication));
    }
}
