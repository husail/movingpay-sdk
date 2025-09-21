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

class EnderecoDto extends BaseDto
{
    public int $id;
    public int $customersId;
    public int $merchantsId;
    public int $tipo;
    public string $cep;
    public string $rua;
    public string $numero;
    public string $bairro;
    public ?string $complemento;
    public string $cidade;
    public ?string $codigoIbge;
    public string $estado;
    public string $pais;
    public \DateTimeImmutable $createdAt;
    public \DateTimeImmutable $updatedAt;
}
