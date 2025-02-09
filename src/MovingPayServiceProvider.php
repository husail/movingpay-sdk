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

use Illuminate\Support\ServiceProvider;

class MovingPayServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/movingpay.php',
            'movingpay'
        );
        $this->app->singleton(Client::class, function ($app) {
            return new Client(
                new Authentication(
                    token: config('movingpay.token'),
                    customerId: config('movingpay.customer_id')
                )
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
