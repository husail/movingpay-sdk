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
use Husail\MovingPay\Contracts\AuthenticationInterface;

final class AuthenticationPlugin implements Plugin
{
    private AuthenticationInterface $authentication;

    /**
     * Instantiate a new Authentication Plugin.
     *
     * @param AuthenticationInterface $authentication The authentication provider used to obtain the authentication header.
     */
    public function __construct(AuthenticationInterface $authentication)
    {
        $this->authentication = $authentication;
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
        $request = $request->withHeader('Authorization', $this->authentication->getAuthenticationHeader());
        $request = $request->withHeader('Customer', $this->authentication->getCustomerIdHeader());

        return $next($request);
    }
}
