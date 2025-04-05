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

class ContadorDto extends BaseDto
{
    public ?TransacaoMetricaDto $aprovadas;
    public ?TransacaoMetricaDto $pendentes;
    public ?TransacaoMetricaDto $negadas;
    public ?TransacaoMetricaDto $desfeitas;
    public ?TransacaoMetricaDto $devolvidas;
    public ?TransacaoMetricaDto $bloqueadas;
    public ?TransacaoMetricaDto $parcialBloqueadas;
}
