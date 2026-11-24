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

use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Husail\MovingPay\Configuration\MtlsConfiguration;
use Husail\MovingPay\Configuration\MovingPayConfiguration;
use Husail\MovingPay\Console\RefreshMovingPayTokenCommand;
use Husail\MovingPay\Configuration\ClientCredentialsConfiguration;
use Husail\MovingPay\HttpClient\Message\Formatter\SimpleFormatter;

class MovingPayServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/movingpay.php',
            'movingpay'
        );
        $this->app->singleton(Client::class, function (Application $app) {
            $logEnabled = config('movingpay.log_enabled', false);
            $outputExpanded = config('movingpay.log_formatter_expanded', false);
            $cache = $app->make('cache')->store(config('movingpay.token_cache_store') ?: null);

            $logger = $logEnabled
                ? $app->make(LoggerInterface::class)
                : null;

            $formatter = $logEnabled
                ? new SimpleFormatter($outputExpanded)
                : null;

            return new Client(
                configuration: new MovingPayConfiguration(
                    credentials: new ClientCredentialsConfiguration(
                        clientId: (string) config('movingpay.client_id'),
                        clientSecret: (string) config('movingpay.client_secret'),
                        tokenUri: (string) config('movingpay.token_uri')
                    ),
                    mtls: new MtlsConfiguration(
                        certificatePath: (string) config('movingpay.mtls_cert'),
                        privateKeyPath: (string) config('movingpay.mtls_key'),
                        caBundlePath: config('movingpay.mtls_ca_bundle') ?: null
                    ),
                    baseUri: (string) config('movingpay.base_uri'),
                    tokenCacheKey: (string) config('movingpay.token_cache_key'),
                    tokenRefreshSkew: (int) config('movingpay.token_refresh_skew', 60)
                ),
                logger: $logger,
                formatter: $formatter,
                tokenCache: $cache instanceof CacheInterface ? $cache : null
            );
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/movingpay.php' => config_path('movingpay.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([RefreshMovingPayTokenCommand::class]);
        }
    }
}
