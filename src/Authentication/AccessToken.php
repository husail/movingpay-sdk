<?php

declare(strict_types=1);

namespace Husail\MovingPay\Authentication;

final class AccessToken
{
    public function __construct(
        public readonly string $value,
        public readonly int $expiresAt,
    ) {}

    /**
     * @param array{access_token?: mixed, expires_in?: mixed} $payload
     */
    public static function fromPayload(array $payload): self
    {
        $token = $payload['access_token'] ?? null;
        $expiresIn = $payload['expires_in'] ?? null;

        if (!is_string($token) || $token === '' || !is_int($expiresIn) && !ctype_digit((string) $expiresIn)) {
            throw new \UnexpectedValueException('MovingPay returned an invalid token response.');
        }

        return new self($token, time() + (int) $expiresIn);
    }

    public function isValid(int $refreshSkew): bool
    {
        return $this->expiresAt > time() + $refreshSkew;
    }

    /**
     * @return array{access_token: string, expires_at: int}
     */
    public function toCacheValue(): array
    {
        return [
            'access_token' => $this->value,
            'expires_at' => $this->expiresAt,
        ];
    }

    /**
     * @param mixed $value
     */
    public static function fromCacheValue(mixed $value): ?self
    {
        if (!is_array($value) || !isset($value['access_token'], $value['expires_at'])
            || !is_string($value['access_token']) || !is_int($value['expires_at'])) {
            return null;
        }

        return new self($value['access_token'], $value['expires_at']);
    }
}
