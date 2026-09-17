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

namespace Husail\MovingPay\Dtos\Dispositivo;

use Husail\MovingPay\Dtos\BaseDto;

class ModeloPaginacaoDto extends BaseDto
{
    public string $message;
    public int $total;
    public int $perPage;
    public int $page;
    public int $lastPage;
    /** @var ModeloDto[] */
    public array $data;
}
