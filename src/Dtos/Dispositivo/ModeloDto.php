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

class ModeloDto extends BaseDto
{
    public int $id;
    public int $customersId;
    public int $fabricantesId;
    public string $fabricantesNome;
    public string $nome;
    public string $tecnologia;
    public string $descricao;
    public int $situacao;
    public \DateTimeImmutable $createdAt;
    public \DateTimeImmutable $updatedAt;
    public ?\DateTimeImmutable $deletedAt;
}
