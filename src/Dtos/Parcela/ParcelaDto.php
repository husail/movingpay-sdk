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

namespace Husail\MovingPay\Dtos\Parcela;

use DateTimeImmutable;
use Husail\MovingPay\Dtos\BaseDto;

class ParcelaDto extends BaseDto
{
    public int $codigoEC;
    public string $estabelecimento;
    public string $cpfCnpj;
    public string $codigoAdquirente;
    public string $nomeAdquirente;
    public int $transactionId;
    public string $codigoAutorizacao;
    public string $tefNSU;
    public string $nsuTransacao;
    public string $bandeira;
    public string $tipo;
    public string $captura;
    public string $capturePartner;
    public DateTimeImmutable $dataVenda;
    public DateTimeImmutable $dataPagamento;
    public string $situacao;
    public int $plano;
    public ?int $mdrAdquirente;
    public int $ecommerce;
    public int $taxaID;
    public string $taxaMdr;
    public string $taxaMdrEcommerce;
    public ?string $contaAdquirente;
    public int $resolucaoAdquirente;
    public string $valorBruto;
    public int $valorReceber;
    public int $mdrBruto;
    public int $liquidoLojista;
    public int $spreadLiquido;
    public int $receitaAntecipacao;
    public int $custoAdicional;
    public int $custoAntecipacao;
    public int $spreadAntecipacao;
    public int $iTC;
    public int $totalAdquirente;
    public int $custoAdministracao;
}
