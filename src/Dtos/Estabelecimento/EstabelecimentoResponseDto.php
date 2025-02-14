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

namespace Husail\MovingPay\Dtos\Estabelecimento;

use Husail\MovingPay\Dtos\BaseDto;

class EstabelecimentoResponseDto extends BaseDto
{
    public EstabelecimentoDto $estabelecimento;
    public ?array $adquirentes;
    public ?array $capturas;
}
