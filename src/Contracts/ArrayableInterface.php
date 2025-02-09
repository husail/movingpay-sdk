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

namespace Husail\MovingPay\Contracts;

interface ArrayableInterface
{
    /**
     * Convert the object to an array.
     *
     * @return array The object converted to an array.
     */
    public function toArray(): array;

    /**
     * Populate the object from an array.
     *
     * @param array $data The data to populate the object with.
     * @return static The populated object.
     */
    public static function fromArray(array $data): static;
}
