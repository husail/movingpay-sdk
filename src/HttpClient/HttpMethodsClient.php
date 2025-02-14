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

namespace Husail\MovingPay\HttpClient;

use Psr\Http\Message\UriInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Husail\MovingPay\Utils\QueryStringBuilder;
use Husail\MovingPay\HttpClient\Message\Response;

final class HttpMethodsClient
{
    private ClientInterface $httpClient;
    private RequestFactoryInterface $requestFactory;
    private ?StreamFactoryInterface $streamFactory;

    /**
     * @param ClientInterface $httpClient
     * @param RequestFactoryInterface $requestFactory
     * @param StreamFactoryInterface|null $streamFactory
     */
    public function __construct(
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        ?StreamFactoryInterface $streamFactory = null
    ) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
    }

    /**
     * @param UriInterface|string $uri
     * @param array $options
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function get(UriInterface|string $uri, array $options = []): Response
    {
        return $this->send('GET', $uri, $options);
    }

    /**
     * @param UriInterface|string $uri
     * @param array $options
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function head(UriInterface|string $uri, array $options = []): Response
    {
        return $this->send('HEAD', $uri, $options);
    }

    /**
     * @param UriInterface|string $uri
     * @param array $options
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function trace(UriInterface|string $uri, array $options = []): Response
    {
        return $this->send('TRACE', $uri, $options);
    }

    /**
     * @param UriInterface|string $uri
     * @param array $options
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function post(UriInterface|string $uri, array $options = []): Response
    {
        return $this->send('POST', $uri, $options);
    }

    /**
     * @param UriInterface|string $uri
     * @param array $options
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function put(UriInterface|string $uri, array $options = []): Response
    {
        return $this->send('PUT', $uri, $options);
    }

    /**
     * @param UriInterface|string $uri
     * @param array $options
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function patch(UriInterface|string $uri, array $options = []): Response
    {
        return $this->send('PATCH', $uri, $options);
    }

    /**
     * @param UriInterface|string $uri
     * @param array $options
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function delete(UriInterface|string $uri, array $options = []): Response
    {
        return $this->send('DELETE', $uri, $options);
    }

    /**
     * @param UriInterface|string $uri
     * @param array $options
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function options(UriInterface|string $uri, array $options = []): Response
    {
        return $this->send('OPTIONS', $uri, $options);
    }

    /**
     * @param string $method
     * @param UriInterface|string $uri
     * @param array $options
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function send(string $method, UriInterface|string $uri, array $options = []): Response
    {
        $request = $this->createRequest($method, $uri, $options);

        return new Response($this->httpClient->sendRequest($request));
    }

    /**
     * @param string $method
     * @param UriInterface|string $uri
     * @param array $options
     * @return RequestInterface
     */
    private function createRequest(string $method, UriInterface|string $uri, array $options = []): RequestInterface
    {
        $headers = $options[RequestOptions::HEADERS] ?? [];
        $body = $options[RequestOptions::BODY] ?? null;
        $query = $options[RequestOptions::QUERY] ?? null;

        if (!empty($query)) {
            $query = QueryStringBuilder::build($query);
            $uri = is_string($uri)
                ? Psr17FactoryDiscovery::findUriFactory()->createUri($uri)->withQuery($query)
                : $uri->withQuery($query);
        }

        $request = $this->requestFactory->createRequest($method, $uri);
        foreach ($headers as $key => $value) {
            $request = $request->withHeader($key, $value);
        }

        if ($body !== null && $body !== '') {
            if ($this->streamFactory === null) {
                throw new \RuntimeException('Cannot create request: A stream factory is required to create a request with a non-empty string body.');
            }

            $request = $request->withBody(
                is_string($body) ? $this->streamFactory->createStream($body) : $body
            );
        }

        return $request;
    }
}
