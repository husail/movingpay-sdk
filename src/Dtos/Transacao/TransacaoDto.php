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

class TransacaoDto extends BaseDto
{
    public int $id;
    public ?int $originalId;
    public string $status;
    public ?string $statusCapture;
    public ?string $statusEdi;
    public ?string $refuseReason;
    public ?string $acquirerResponseCode;
    public ?string $acquirerName;
    public ?string $acquirerId;
    public ?string $authorizationCode;
    public ?string $tefNsu;
    public ?string $nsuLancamento;
    public string $uuid;
    public ?array $splitRules;
    public string $nsu;
    public int $amount;
    public ?int $amountOperation;
    public ?int $feeOperation;
    public ?int $refundedAmount;
    public ?int $custoMdr;
    public ?int $custoAdquirente;
    public ?int $valorInterchange;
    public ?int $valorTaxaAdministracao;
    public ?int $installments;
    public ?int $merchantId;
    public ?string $merchantKey;
    public ?string $merchantRefExterna;
    public ?string $merchantName;
    public ?string $merchantDocumentNumber;
    public ?string $cardHolderName;
    public ?string $cardFirstDigits;
    public ?string $cardLastDigits;
    public ?string $cardBrand;
    public ?int $cardPinMode;
    public ?string $paymentMethod;
    public ?string $captureMethod;
    public ?string $capturePartner;
    public ?string $deviceSerialNumber;
    public ?string $simcardProvider;
    public ?string $simcardSerialNumber;
    public mixed $vlComissao;
    public mixed $boletoValor;
    public ?string $codigoBarras;
    public mixed $ecommerce;
    public mixed $contaAdquirente;
    public mixed $codigoTransacao;
    public mixed $nsuSitef;
    public mixed $merchantCodeSitef;
    public mixed $pv;
    public ?string $logicNumber;
    public mixed $codigoPedido;
    public ?string $nsuHost;
    public ?string $valorCancelado;
    public ?int $blockedPayablesCount;
    public ?string $custoAdicional;
    public ?int $resolucaoCaptura;
    public ?int $resolucaoAdquirente;
    public ?string $tipoResolucao;
    public ?string $mensagemResolucao;
    public ?DateTimeImmutable $startDate;
    public ?DateTimeImmutable $finishDate;
    public ?DateTimeImmutable $confirmationDate;
    public ?DateTimeImmutable $paymentDate;
    public ?DateTimeImmutable $statusCaptureDate;
    public ?DateTimeImmutable $statusEdiDate;
    public ?DateTimeImmutable $createdAt;
    public ?DateTimeImmutable $updatedAt;
    public ?DateTimeImmutable $deletedAt;
}
