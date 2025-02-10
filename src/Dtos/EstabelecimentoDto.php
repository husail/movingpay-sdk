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

namespace Husail\MovingPay\Dtos;

class EstabelecimentoDto extends BaseDto
{
    public int $codigoCliente;
    public ?string $referenciaExterna;
    public ?string $descricao;
    public string $razaoSocial;
    public string $nomeFantasia;
    public string $cpfCnpj;
    public ?string $inscricaoEstadual;
    public ?string $inscricaoFazenda;
    public ?string $tipoEmpresa;
    public \DateTimeImmutable $dataFundacao;
    public ?string $contatoPrincipal;
    public ?int $horarioFuncionamento;
    public ?int $localizadoShopping;
    public ?string $faturamentoMensal;
    public ?int $bloquearLiquidacao;
    public ?int $planoId;
    public ?string $planoNome;
    public ?int $unidadeNegocioId;
    public ?string $unidadeNegocioNome;
    public ?int $codigoVendedor;
    public ?string $nomeVendedor;
    public ?string $recipientId;
    public ?string $urlEcommerce;
    public ?int $transferenciaAutomatica;
    public ?string $transferenciaValorMinimo;
    public ?string $transferenciaPeriodicidade;
    public ?int $divisaoTransferenciaEntreContasBancarias;
    public ?int $antecipacaoRecebiveis;
    public ?string $percentualAntecipacao;
    public ?string $tipoAntecipacao;
    public ?int $periodoCarencia;
    public ?string $ordemAntecipacao;
    public ?\DateTimeImmutable $dataAntecipacao;
    public ?int $antecipacaoAppEC;
    public ?int $anteciparApos;
    public ?int $jurosCompostoAntecipacao;
    public ?\DateTimeImmutable $dataInicioVigorJurosComposto;
    public ?string $valorPatrimonio;
    public ?string $sincronizarEDI;
    public ?\DateTimeImmutable $sincronizarData;
    public ?string $sincronizacao;
    public ?int $informeRegistradora;
    public ?string $analistaRelacionamento;
    public ?string $modeloCobrancaChargeback;
    public ?string $modeloCobrancaCancelamento;
    public ?int $situacao;
    public ?string $motivoDescredenciamento;
    public ?\DateTimeImmutable $dataDescredenciamento;
    public ?\DateTimeImmutable $createdAt;
    public ?\DateTimeImmutable $updatedAt;
}
