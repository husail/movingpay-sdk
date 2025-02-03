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

use Husail\MovingPay\Contracts\AuthenticationInterface;

class Authentication implements AuthenticationInterface
{
    public const OAUTH_TOKEN = 'oauth_token';

    private string $authHeader;
    private string $customerIdHeader;

    public function __construct(string $token, string $customerId, string $authType = Authentication::OAUTH_TOKEN)
    {
        $this->authHeader = match ($authType) {
            Authentication::OAUTH_TOKEN => \sprintf('Bearer %s', $token),
            default => throw new \InvalidArgumentException('Invalid authentication type'),
        };
        $this->customerIdHeader = $customerId;
    }

    public function getAuthenticationHeader(): string
    {
        return $this->authHeader;
    }

    public function getCustomerIdHeader(): string
    {
        return $this->customerIdHeader;
    }
}
