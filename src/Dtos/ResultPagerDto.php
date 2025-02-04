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

use Husail\MovingPay\Dtos\BaseDto;
use Husail\MovingPay\Dtos\EstabelecimentoDto;

class ResultPagerDto extends BaseDto
{
    public int $agenda;
    public int $page;
    public int $total;
    public int $perPage;
    public int $lastPage;
    /** @var array<int, EstabelecimentoDto> */
    public array $data;
}
