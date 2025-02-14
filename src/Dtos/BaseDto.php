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

namespace Husail\MovingPay\Dtos;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use Husail\MovingPay\Contracts\DtoInterface;
use Husail\MovingPay\Contracts\ArrayableInterface;
use Husail\MovingPay\Factories\ValinorMapperFactory;

abstract class BaseDto implements ArrayableInterface, DtoInterface
{
    /**
     * Convert the object to an array.
     *
     * @return array The object converted to an array.
     */
    public function toArray(): array
    {
        return json_decode(json_encode($this), true);
    }

    /**
     * Populate the object from an array.
     *
     * @param array $data The data to populate the object with.
     * @return static The populated object.
     *
     * @throws MappingError
     */
    public static function fromArray(array $data): static
    {
        return ValinorMapperFactory::makeMapper()
            ->map(static::class, Source::array($data)->camelCaseKeys());
    }
}
