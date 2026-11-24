<?php

declare(strict_types=1);

namespace Husail\MovingPay\Tests\HttpClient\Plugin;

use Laminas\Diactoros\Request;
use Laminas\Diactoros\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Http\Client\Promise\HttpFulfilledPromise;
use Husail\MovingPay\Contracts\AccessTokenProviderInterface;
use Husail\MovingPay\HttpClient\Plugin\AuthenticationPlugin;

final class AuthenticationPluginTest extends TestCase
{
    public function test_it_adds_bearer_authentication_only_for_the_configured_host(): void
    {
        $plugin = new AuthenticationPlugin($this->tokenProvider(), 'api-backoffice-mtls.movingpay.com.br');
        $sentRequest = null;

        $promise = $plugin->handleRequest(
            new Request('https://api-backoffice-mtls.movingpay.com.br/api/v3/transacoes'),
            static function (RequestInterface $request) use (&$sentRequest): HttpFulfilledPromise {
                $sentRequest = $request;

                return new HttpFulfilledPromise(new Response());
            },
            static fn (): null => null
        );

        $promise->wait();

        self::assertSame('Bearer token-value', $sentRequest->getHeaderLine('Authorization'));
        self::assertFalse($sentRequest->hasHeader('Customer'));
    }

    public function test_it_rejects_an_untrusted_host(): void
    {
        $plugin = new AuthenticationPlugin($this->tokenProvider(), 'api-backoffice-mtls.movingpay.com.br');

        $this->expectException(\LogicException::class);
        $plugin->handleRequest(
            new Request('https://example.test'),
            static fn (): HttpFulfilledPromise => new HttpFulfilledPromise(new Response()),
            static fn (): null => null
        );
    }

    public function test_it_retries_once_with_a_new_token_after_an_unauthorized_response(): void
    {
        $provider = new class() implements AccessTokenProviderInterface
        {
            public int $calls = 0;
            public int $invalidations = 0;

            public function getAccessToken(): string
            {
                ++$this->calls;

                return $this->calls === 1 ? 'expired-token' : 'new-token';
            }

            public function invalidate(): void
            {
                ++$this->invalidations;
            }

            public function refresh(): string
            {
                return $this->getAccessToken();
            }
        };
        $plugin = new AuthenticationPlugin($provider, 'api-backoffice-mtls.movingpay.com.br');
        $requests = [];

        $response = $plugin->handleRequest(
            new Request('https://api-backoffice-mtls.movingpay.com.br/api/v3/transacoes'),
            static function (RequestInterface $request) use (&$requests): HttpFulfilledPromise {
                $requests[] = $request;

                return new HttpFulfilledPromise((new Response())->withStatus(count($requests) === 1 ? 401 : 200));
            },
            static fn (): null => null
        )->wait();

        self::assertSame(200, $response->getStatusCode());
        self::assertSame(1, $provider->invalidations);
        self::assertSame('Bearer new-token', $requests[1]->getHeaderLine('Authorization'));
    }

    private function tokenProvider(): AccessTokenProviderInterface
    {
        return new class() implements AccessTokenProviderInterface
        {
            public function getAccessToken(): string
            {
                return 'token-value';
            }

            public function invalidate(): void {}

            public function refresh(): string
            {
                return 'token-value';
            }
        };
    }
}
