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

namespace Husail\MovingPay\Factories;

use DateTimeInterface;
use CuyZ\Valinor\MapperBuilder;
use CuyZ\Valinor\Mapper\TreeMapper;

final class ValinorMapperFactory
{
    public static function makeMapper(): TreeMapper
    {
        return (new MapperBuilder())
            ->supportDateFormats(
                DateTimeInterface::ATOM,
                'Y-m-d\\TH:i:s.v\\Z',
                'Y-m-d H:i:s',
                'Y-m-d'
            )
            ->allowPermissiveTypes()
            ->allowSuperfluousKeys()
            ->enableFlexibleCasting()
            ->mapper();
    }
}
