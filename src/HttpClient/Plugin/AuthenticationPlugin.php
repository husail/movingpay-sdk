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

namespace Husail\MovingPay\HttpClient\Plugin;

use Http\Promise\Promise;
use Http\Client\Common\Plugin;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Husail\MovingPay\Contracts\AccessTokenProviderInterface;

final class AuthenticationPlugin implements Plugin
{
    private AccessTokenProviderInterface $tokenProvider;
    private string $allowedHost;

    /**
     * Instantiate a new Authentication Plugin.
     *
     * @param AccessTokenProviderInterface $tokenProvider The provider used to obtain the access token.
     * @param string $allowedHost The MovingPay API host allowed to receive credentials.
     */
    public function __construct(AccessTokenProviderInterface $tokenProvider, string $allowedHost)
    {
        $this->tokenProvider = $tokenProvider;
        $this->allowedHost = $allowedHost;
    }

    /**
     * Handles the request by adding the Authorization header.
     *
     * This method intercepts the outgoing request and modifies it by adding an 'Authorization' header. The header
     * value is retrieved from the authentication service. The modified request is then passed on to the next handler
     * in the stack.
     *
     * @param RequestInterface $request The HTTP request.
     * @param callable $next The next handler to call.
     * @param callable $first The first handler in the chain.
     * @return Promise The promise representing the modified request.
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $uri = $request->getUri();
        if ($uri->getScheme() !== 'https' || $uri->getHost() !== $this->allowedHost) {
            throw new \LogicException('MovingPay credentials can only be sent to the configured HTTPS API host.');
        }

        $request = $request->withHeader('Authorization', sprintf('Bearer %s', $this->tokenProvider->getAccessToken()));

        return $next($request)->then(function (ResponseInterface $response) use ($next, $request) {
            if ($response->getStatusCode() === 401) {
                $this->tokenProvider->invalidate();
                if ($request->getBody()->isSeekable()) {
                    $request->getBody()->rewind();
                }

                return $next(
                    $request->withHeader('Authorization', sprintf('Bearer %s', $this->tokenProvider->getAccessToken()))
                )->wait();
            }

            return $response;
        });
    }
}
