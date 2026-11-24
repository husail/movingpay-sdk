<?php

declare(strict_types=1);

namespace Husail\MovingPay\Authentication;

use Psr\SimpleCache\CacheInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Husail\MovingPay\Contracts\AccessTokenProviderInterface;
use Husail\MovingPay\Configuration\ClientCredentialsConfiguration;

final class ClientCredentialsTokenProvider implements AccessTokenProviderInterface
{
    private ?AccessToken $inMemoryToken = null;

    public function __construct(
        private ClientCredentialsConfiguration $configuration,
        private ClientInterface $httpClient,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory,
        private ?CacheInterface $cache = null,
        private string $cacheKey = 'movingpay:access-token',
        private int $refreshSkew = 60,
    ) {}

    public function getAccessToken(): string
    {
        if ($this->inMemoryToken?->isValid($this->refreshSkew)) {
            return $this->inMemoryToken->value;
        }

        $cachedToken = $this->getCachedToken();
        if ($cachedToken?->isValid($this->refreshSkew)) {
            $this->inMemoryToken = $cachedToken;

            return $cachedToken->value;
        }

        return $this->refreshWithLock();
    }

    public function invalidate(): void
    {
        $this->inMemoryToken = null;

        if ($this->cache !== null) {
            $this->cache->delete($this->cacheKey);
        }
    }

    public function refresh(): string
    {
        $body = http_build_query([
            'grant_type' => 'client_credentials',
            'client_id' => $this->configuration->clientId,
            'client_secret' => $this->configuration->clientSecret,
        ], '', '&', PHP_QUERY_RFC3986);

        $request = $this->requestFactory
            ->createRequest('POST', $this->configuration->tokenUri)
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->withHeader('Accept', 'application/json')
            ->withBody($this->streamFactory->createStream($body));

        $response = $this->httpClient->sendRequest($request);

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            throw new \RuntimeException(sprintf('Unable to authenticate with MovingPay (HTTP %d).', $response->getStatusCode()));
        }

        $payload = json_decode((string) $response->getBody(), true);
        if (!is_array($payload)) {
            throw new \UnexpectedValueException('MovingPay returned an invalid token response.');
        }

        $token = AccessToken::fromPayload($payload);
        $this->inMemoryToken = $token;

        if ($this->cache !== null) {
            $ttl = max(1, $token->expiresAt - time());
            $this->cache->set($this->cacheKey, $token->toCacheValue(), $ttl);
        }

        return $token->value;
    }

    private function getCachedToken(): ?AccessToken
    {
        return $this->cache === null
            ? null
            : AccessToken::fromCacheValue($this->cache->get($this->cacheKey));
    }

    private function refreshWithLock(): string
    {
        if ($this->cache === null || !method_exists($this->cache, 'lock')) {
            return $this->refresh();
        }

        /** @var mixed $lock */
        $lock = $this->cache->lock($this->cacheKey . ':refresh', 30);

        /** @var string $token */
        $token = $lock->block(5, function (): string {
            $cachedToken = $this->getCachedToken();
            if ($cachedToken?->isValid($this->refreshSkew)) {
                $this->inMemoryToken = $cachedToken;

                return $cachedToken->value;
            }

            return $this->refresh();
        });

        return $token;
    }
}
