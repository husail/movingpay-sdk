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

namespace Husail\MovingPay\Dtos\Distribuidor;

use Husail\MovingPay\Dtos\BaseDto;

class DistribuidorDto extends BaseDto
{
    public int $id;
    public string $nome;
    public ?string $fantasia;
    public string $email;
    public string $cpfCnpj;
    public string $celular;
    public string $rua;
    public string $numero;
    public string $bairro;
    public string $cep;
    public string $estado;
    public int|float|null $percentualIof;
    public int|float|null $percentualIr;
    public int|float|null $descontoMoeda;
    public int|float|null $custoTransacao;
    public int|float|null $percentualComissao;
    public int|float|null $custoAdquirencia;
    public ?string $urlLogo;
    /** @var array<string, mixed>|null */
    public ?array $configVendedor;
    public int $situacao;
    public \DateTimeImmutable $createdAt;
    public \DateTimeImmutable $updatedAt;
}
