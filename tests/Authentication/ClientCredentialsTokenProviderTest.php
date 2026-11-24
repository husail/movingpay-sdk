<?php

declare(strict_types=1);

namespace Husail\MovingPay\Tests\Authentication;

use Http\Mock\Client;
use Laminas\Diactoros\Stream;
use Laminas\Diactoros\Response;
use PHPUnit\Framework\TestCase;
use Laminas\Diactoros\StreamFactory;
use Laminas\Diactoros\RequestFactory;
use Husail\MovingPay\Configuration\ClientCredentialsConfiguration;
use Husail\MovingPay\Authentication\ClientCredentialsTokenProvider;

final class ClientCredentialsTokenProviderTest extends TestCase
{
    public function test_it_requests_and_reuses_an_access_token(): void
    {
        $httpClient = new Client();
        $httpClient->addResponse($this->jsonResponse([
            'access_token' => 'access-token',
            'expires_in' => 900,
            'token_type' => 'Bearer',
        ]));

        $provider = new ClientCredentialsTokenProvider(
            new ClientCredentialsConfiguration('client-id', 'client-secret'),
            $httpClient,
            new RequestFactory(),
            new StreamFactory(),
        );

        self::assertSame('access-token', $provider->getAccessToken());
        self::assertSame('access-token', $provider->getAccessToken());

        $requests = $httpClient->getRequests();
        self::assertCount(1, $requests);
        self::assertSame('POST', $requests[0]->getMethod());
        self::assertSame('application/x-www-form-urlencoded', $requests[0]->getHeaderLine('Content-Type'));
        self::assertSame(
            'grant_type=client_credentials&client_id=client-id&client_secret=client-secret',
            (string) $requests[0]->getBody()
        );
    }

    public function test_it_rejects_an_invalid_token_response(): void
    {
        $httpClient = new Client();
        $httpClient->addResponse($this->jsonResponse(['expires_in' => 900]));

        $provider = new ClientCredentialsTokenProvider(
            new ClientCredentialsConfiguration('client-id', 'client-secret'),
            $httpClient,
            new RequestFactory(),
            new StreamFactory(),
        );

        $this->expectException(\UnexpectedValueException::class);
        $provider->getAccessToken();
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function jsonResponse(array $payload): Response
    {
        $stream = new Stream('php://memory', 'rw');
        $stream->write((string) json_encode($payload));
        $stream->rewind();

        return (new Response())->withBody($stream);
    }
}
