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

class DispositivoDto extends BaseDto
{
    public int $id;
    public string $fabricante;
    public string $modelo;
    public string $numeroSerie;
    public string $tecnologia;
    public int $situacao;
    public string $descricaoSituacao;
    public string $cpfCnpj;
    public string $razaoSocial;
    public int $estabelecimentoId;
    public int $codigoCaptura;
    public string $finalidade;
    public string $valor;
    public \DateTimeImmutable $createdAt;
    public \DateTimeImmutable $updatedAt;
}
