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

use DateTimeImmutable;
use Husail\MovingPay\Dtos\BaseDto;

class ContatoDto extends BaseDto
{
    public int $id;
    public int $mid;
    public string $responsavelTipo;
    public ?string $nome;
    public ?string $cpfCnpj;
    public ?DateTimeImmutable $dataNascimento;
    public ?string $nomeMae;
    public ?string $nacionalidade;
    public ?string $descricaoFuncao;
    public ?string $ddi;
    public ?string $ddd;
    public ?string $numero;
    public ?string $email;
    public ?string $site;
    public DateTimeImmutable $createdAt;
    public ?DateTimeImmutable $updatedAt;
}
