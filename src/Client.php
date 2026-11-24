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
use Husail\MovingPay\Apis\Acordo;
use Husail\MovingPay\Apis\Parcela;
use Psr\Http\Message\UriInterface;
use Psr\SimpleCache\CacheInterface;
use Husail\MovingPay\Apis\Transacao;
use Laminas\Diactoros\StreamFactory;
use Laminas\Diactoros\RequestFactory;
use Husail\MovingPay\Apis\Dispositivo;
use Husail\MovingPay\Apis\CategoriaMcc;
use Husail\MovingPay\Apis\Distribuidor;
use Husail\MovingPay\HttpClient\Builder;
use Husail\MovingPay\Apis\Estabelecimento;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Husail\MovingPay\HttpClient\HttpMethodsClient;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Husail\MovingPay\HttpClient\Plugin\LoggerPlugin;
use Husail\MovingPay\HttpClient\CurlMtlsClientFactory;
use Husail\MovingPay\Configuration\MovingPayConfiguration;
use Husail\MovingPay\Contracts\AccessTokenProviderInterface;
use Husail\MovingPay\HttpClient\Plugin\AuthenticationPlugin;
use Husail\MovingPay\Contracts\Http\Message\FormatterInterface;
use Husail\MovingPay\HttpClient\Message\Formatter\SimpleFormatter;
use Husail\MovingPay\Authentication\ClientCredentialsTokenProvider;

/**
 * MovingPay Client
 *
 * @property-read Estabelecimento $estabelecimento
 * @property-read Transacao $transacao
 * @property-read Dispositivo $dispositivo
 * @property-read Distribuidor $distribuidor
 * @property-read CategoriaMcc $categoriaMcc
 * @property-read Parcela $parcela
 */
final class Client
{
    public const PACKAGE_NAME = 'MovingPay';
    public const USER_AGENT = 'movingpay-php-sdk/1.0';
    private Builder $httpClientBuilder;
    private MovingPayConfiguration $configuration;
    private AccessTokenProviderInterface $tokenProvider;
    public readonly Estabelecimento $estabelecimento;
    public readonly Transacao $transacao;
    public readonly Acordo $acordo;
    public readonly Dispositivo $dispositivo;
    public readonly Distribuidor $distribuidor;
    public readonly CategoriaMcc $categoriaMcc;
    public readonly Parcela $parcela;

    public function __construct(
        MovingPayConfiguration $configuration,
        ?Builder $httpClientBuilder = null,
        ?LoggerInterface $logger = null,
        ?FormatterInterface $formatter = null,
        ?CacheInterface $tokenCache = null,
    ) {
        $this->configuration = $configuration;
        $this->httpClientBuilder = $httpClientBuilder ?? new Builder(CurlMtlsClientFactory::create($configuration->mtls));
        $this->tokenProvider = new ClientCredentialsTokenProvider(
            $configuration->credentials,
            CurlMtlsClientFactory::createDefault(),
            new RequestFactory(),
            new StreamFactory(),
            $tokenCache,
            $configuration->tokenCacheKey,
            $configuration->tokenRefreshSkew,
        );
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

        $this->httpClientBuilder->addPlugin(new AuthenticationPlugin(
            $this->tokenProvider,
            $this->factoryBaseUri()->getHost()
        ));
        if (!empty($logger)) {
            $this->httpClientBuilder->addPlugin(new LoggerPlugin(Client::PACKAGE_NAME, $logger, $formatter ?? new SimpleFormatter()));
        }

        $this->estabelecimento = new Estabelecimento($this->getHttpClient());
        $this->transacao = new Transacao($this->getHttpClient());
        $this->acordo = new Acordo($this->getHttpClient());
        $this->dispositivo = new Dispositivo($this->getHttpClient());
        $this->distribuidor = new Distribuidor($this->getHttpClient());
        $this->categoriaMcc = new CategoriaMcc($this->getHttpClient());
        $this->parcela = new Parcela($this->getHttpClient());
    }

    private function factoryBaseUri(): UriInterface
    {
        return (new \Laminas\Diactoros\UriFactory())->createUri($this->configuration->baseUri);
    }

    public function getHttpClient(): HttpMethodsClient
    {
        return $this->httpClientBuilder->getHttpClient();
    }

    public function refreshAccessToken(): string
    {
        return $this->tokenProvider->refresh();
    }

    public function ensureAccessToken(): string
    {
        return $this->tokenProvider->getAccessToken();
    }
}
