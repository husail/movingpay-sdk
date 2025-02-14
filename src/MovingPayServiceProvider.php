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
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
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

            $logger = $logEnabled
                ? $app->make(LoggerInterface::class)
                : null;

            $formatter = $logEnabled
                ? new SimpleFormatter($outputExpanded)
                : null;

            return new Client(
                authentication: new Authentication(
                    token: config('movingpay.token'),
                    customerId: config('movingpay.customer_id')
                ),
                logger: $logger,
                formatter: $formatter
            );
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/movingpay.php' => config_path('movingpay.php'),
        ], 'config');
    }
}
