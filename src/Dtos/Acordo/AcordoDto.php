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

namespace Husail\MovingPay\Dtos\Acordo;

use Husail\MovingPay\Dtos\BaseDto;

class AcordoDto extends BaseDto
{
    public int $id;
    public int $merchantsId;
    public int $ratesId;
    public int $codigoAdquirente;
    public ?string $mcc;
    public string $mdrEcommerce;
    public string $mdrPresencial;
    public string $antecipacaoSpot;
    public string $antecipacaoRav;
    public string $spotOnline;
    public string $ravOnline;
    public string $valorMinTransacao;
    public ?string $custoTransacao;
    public ?string $custoTransacaoPresencial;
    public ?string $custoTransacaoEcommerce;
    public string $tipo;
    public string $diasPgto;
    public int $codigoBandeira;
    public string $nomeBandeira;
    public string $produto;
    public \DateTimeImmutable $createdAt;
    public \DateTimeImmutable $updatedAt;
}
