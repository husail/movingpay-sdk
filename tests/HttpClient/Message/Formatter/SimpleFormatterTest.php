<?php

declare(strict_types=1);

namespace Husail\MovingPay\Tests\HttpClient\Message\Formatter;

use Laminas\Diactoros\Stream;
use Laminas\Diactoros\Request;
use PHPUnit\Framework\TestCase;
use Husail\MovingPay\HttpClient\Message\Formatter\SimpleFormatter;

final class SimpleFormatterTest extends TestCase
{
    public function test_it_redacts_authorization_and_oauth_secrets(): void
    {
        $stream = new Stream('php://memory', 'rw');
        $stream->write('client_secret=super-secret&access_token=access-token');
        $stream->rewind();

        $request = (new Request('https://api-backoffice-mtls.movingpay.com.br'))
            ->withHeader('Authorization', 'Bearer access-token')
            ->withBody($stream);

        $formatted = (new SimpleFormatter())->formatRequest($request, null);

        self::assertStringNotContainsString('super-secret', $formatted);
        self::assertStringNotContainsString('Bearer access-token', $formatted);
        self::assertStringContainsString('[REDACTED]', $formatted);
    }
}
