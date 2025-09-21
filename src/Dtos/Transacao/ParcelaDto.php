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

use DateTimeImmutable;
use Husail\MovingPay\Dtos\BaseDto;

class ParcelaDto extends BaseDto
{
    public int $id;
    public int $transacaoId;
    public int $transacaoOriginalId;
    public string $transacaoStatus;
    public ?int $ValorBruto;
    public ?int $ValorLiquido;
    public ?int $Mdr;
    public ?string $MdrAntecipacao;
    public ?int $CustoAntecipacao;
    public ?int $ParcelaNr;
    public ?DateTimeImmutable $DataPagto;
    public ?DateTimeImmutable $DataPgtoOriginal;
    public ?DateTimeImmutable $DataAntecipacao;
    public ?DateTimeImmutable $dataCancelamento;
    public ?string $DiasRav;
    public ?string $Tipo;
    public ?string $Situacao;
    public ?DateTimeImmutable $createdAt;
    public ?DateTimeImmutable $updatedAt;
    public ?int $splitRuleId;
    public ?int $vl_cancelamento;
    public ?int $vlCancelamento;
    public mixed $liable;
    public mixed $chargeProcessingFee;
    public mixed $primary;
    public ?int $merchantsId;
    public ?string $socialReason;
    public mixed $chaveRegistro;
    public mixed $chaveLiquidacao;
    public ?int $inativarUr;
    public ?DateTimeImmutable $dataInativacaoUr;
}
