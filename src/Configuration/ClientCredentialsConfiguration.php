<?php

declare(strict_types=1);

namespace Husail\MovingPay\Configuration;

final class ClientCredentialsConfiguration
{
    public const DEFAULT_TOKEN_URI = 'https://sso.movingpay.com.br/realms/prd-movingpay/protocol/openid-connect/token';

    public function __construct(
        public readonly string $clientId,
        public readonly string $clientSecret,
        public readonly string $tokenUri = self::DEFAULT_TOKEN_URI,
    ) {
        if ($clientId === '' || $clientSecret === '') {
            throw new \InvalidArgumentException('MovingPay client credentials are required.');
        }

        $this->validateHttpsUri($tokenUri, 'token URI');
    }

    private function validateHttpsUri(string $uri, string $label): void
    {
        $parts = parse_url($uri);

        if ($parts === false || ($parts['scheme'] ?? null) !== 'https' || empty($parts['host'])) {
            throw new \InvalidArgumentException(sprintf('The MovingPay %s must be a valid HTTPS URI.', $label));
        }
    }
}
