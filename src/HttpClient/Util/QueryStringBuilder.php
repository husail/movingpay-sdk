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

namespace Husail\MovingPay\HttpClient\Util;

final class QueryStringBuilder
{
    public static function build(array|string $query): string
    {
        if (is_string($query)) {
            return $query;
        }
        if (\count($query) === 0) {
            return '';
        }

        return \sprintf('%s', \http_build_query($query, '', '&', \PHP_QUERY_RFC3986));
    }
}
