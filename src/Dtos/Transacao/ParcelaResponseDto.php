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

namespace Husail\MovingPay\Dtos\Transacao;

use Husail\MovingPay\Dtos\BaseDto;

class ParcelaResponseDto extends BaseDto
{
    public int $valorTotal;
    public int $valorCancelamento;
    public int $mdrTotal;
    public int $ravTotal;
    public int $valorLiquido;
    public bool $split;
    /** @var ParcelaDto[] */
    public array $data;
}
