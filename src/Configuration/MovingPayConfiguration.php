<?php

declare(strict_types=1);

namespace Husail\MovingPay\Configuration;

final class MovingPayConfiguration
{
    public const DEFAULT_BASE_URI = 'https://api-backoffice-mtls.movingpay.com.br/api/v3';

    public function __construct(
        public readonly ClientCredentialsConfiguration $credentials,
        public readonly MtlsConfiguration $mtls,
        public readonly string $baseUri = self::DEFAULT_BASE_URI,
        public readonly string $tokenCacheKey = 'movingpay:access-token',
        public readonly int $tokenRefreshSkew = 60,
    ) {
        $parts = parse_url($baseUri);

        if ($parts === false || ($parts['scheme'] ?? null) !== 'https' || empty($parts['host'])) {
            throw new \InvalidArgumentException('The MovingPay base URI must be a valid HTTPS URI.');
        }

        if ($tokenRefreshSkew < 0) {
            throw new \InvalidArgumentException('The token refresh skew cannot be negative.');
        }
    }
}
