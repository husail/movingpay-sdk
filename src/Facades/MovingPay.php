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

namespace Husail\MovingPay\Facades;

use Husail\MovingPay\Client;
use Illuminate\Support\Facades\Facade;
use Husail\MovingPay\Apis\Estabelecimento;

/**
 * @property-read Estabelecimento $estabelecimento
 */
class MovingPay extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Client::class;
    }

    public static function client(): Client
    {
        return self::getFacadeRoot();
    }
}
