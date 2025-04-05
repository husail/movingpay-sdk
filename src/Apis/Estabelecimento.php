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

namespace Husail\MovingPay\Apis;

use Psr\Http\Client\ClientExceptionInterface;
use Husail\MovingPay\HttpClient\RequestOptions;
use Husail\MovingPay\HttpClient\Message\Response;
use Husail\MovingPay\Dtos\Estabelecimento\DepartamentosPaginacaoDto;
use Husail\MovingPay\Dtos\Estabelecimento\EstabelecimentoResponseDto;
use Husail\MovingPay\Dtos\Estabelecimento\EstabelecimentoPaginacaoDto;

final class Estabelecimento extends AbstractApi
{
    /**
     * Consultar Estabelecimentos.
     *
     * Filtros opcionais para busca de estabelecimentos:
     * - `social_reason` (string, opcional): Razão social da empresa.
     * - `document_number` (string, opcional): CPF ou CNPJ do estabelecimento.
     * - `nomeFantasia` (string, opcional): Nome fantasia da empresa.
     * - `codigoCliente` (string, opcional): Código único do cliente.
     * - `search` (string, opcional): Pesquisa geral nos campos `codigoCliente`, `nomeFantasia`, `document_number` e `social_reason`.
     * - `matchAny` (int, opcional): Busca parcial em múltiplas palavras nos resultados do campo `search`.
     *   Valores possíveis:
     *   - `0`: Falso
     *   - `1`: Verdadeiro
     * - `limit` (int, opcional): Limita a quantidade de registros retornados em cada página.
     * - `page` (int, opcional): Define o número da página de resultados que será retornada.
     *
     * @param array{
     *     social_reason?: string,
     *     document_number?: string,
     *     nomeFantasia?: string,
     *     codigoCliente?: string,
     *     search?: string,
     *     matchAny?: int,
     *     limit?: int,
     *     page?: int
     * } $filters
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function all(array $filters = []): Response
    {
        $response = $this->httpClient->get('/estabelecimentos', [
            RequestOptions::QUERY => $filters,
        ]);

        return $response->setResponseDto(EstabelecimentoPaginacaoDto::class);
    }

    /**
     * Obter estabelecimento pelo código do cliente
     *
     * @param int|string $codigoCliente
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function get(int|string $codigoCliente): Response
    {
        $response = $this->httpClient->get('/estabelecimentos/visualizar', [
            RequestOptions::QUERY => [
                'id' => $codigoCliente,
            ],
        ]);

        return $response->setResponseDto(EstabelecimentoResponseDto::class);
    }

    /**
     * Obter departamentos do estabelecimento
     *
     * @param int|string $codigoCliente
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function departaments(int|string $codigoCliente): Response
    {
        $response = $this->httpClient->get('/departamentos', [
            RequestOptions::QUERY => [
                'mid' => $codigoCliente,
            ],
        ]);

        return $response->setResponseDto(DepartamentosPaginacaoDto::class);
    }
}
