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

class DepartamentosDto extends BaseDto
{
    public int $id;
    public string $descricao;
    public string $mcc;
    public string $cnae;
    public int $padrao;
    public int $situacao;
    public \DateTimeImmutable $createdAt;
    public \DateTimeImmutable $updatedAt;
}
