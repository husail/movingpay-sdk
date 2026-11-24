<?php

declare(strict_types=1);

namespace Husail\MovingPay\Contracts;

interface AccessTokenProviderInterface
{
    public function getAccessToken(): string;

    public function invalidate(): void;

    public function refresh(): string;
}
