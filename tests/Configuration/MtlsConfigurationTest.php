<?php

declare(strict_types=1);

namespace Husail\MovingPay\Tests\Configuration;

use PHPUnit\Framework\TestCase;
use Husail\MovingPay\Configuration\MtlsConfiguration;

final class MtlsConfigurationTest extends TestCase
{
    public function test_it_requires_readable_certificate_and_key_files(): void
    {
        $certificate = tempnam(sys_get_temp_dir(), 'movingpay-cert-');
        $key = tempnam(sys_get_temp_dir(), 'movingpay-key-');

        try {
            self::assertInstanceOf(MtlsConfiguration::class, new MtlsConfiguration($certificate, $key));
        } finally {
            unlink($certificate);
            unlink($key);
        }
    }

    public function test_it_rejects_a_missing_certificate(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new MtlsConfiguration('/does/not/exist.pem', '/does/not/exist.key');
    }
}
