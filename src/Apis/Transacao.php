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
use Husail\MovingPay\Dtos\Transacao\ParcelaResponseDto;
use Husail\MovingPay\Dtos\Transacao\TransacaoResponseDto;

final class Transacao extends AbstractApi
{
    /**
     * Consultar Transações.
     *
     * Filtros opcionais para busca de transações:
     * - start_date (string, opcional): Data do início da venda (formato YYYY-MM-DD).
     * - finish_date (string, opcional): Data do fim da venda (formato YYYY-MM-DD).
     * - NSU (string, opcional): Identificador NSU da transação.
     * - LojaID (string, opcional): Código de identificação da loja.
     * - Situacao (string, opcional): Situação da transação.
     * - Bandeira (string, opcional): Bandeira do cartão.
     * - Adquirente (string, opcional): Código de cadastro das adquirentes.
     * - TipoTransacao (int, opcional): Tipo da transação (0: Presencial, 1: E-Commerce).
     * - capture_method (string, opcional): Forma de captura da transação.
     * - capture_partner (string, opcional): Provedor da transação.
     * - orderby (string, opcional): Campo para ordenação dos resultados (ex: start_date,asc).
     * - page (int, opcional): Número da página para paginação.
     * - limit (int, opcional): Número máximo de itens por página.
     *
     * @param array{
     * start_date?: string,
     * finish_date?: string,
     * NSU?: string,
     * LojaID?: string,
     * Situacao?: string,
     * Bandeira?: string,
     * Adquirente?: string,
     * TipoTransacao?: int,
     * capture_method?: string,
     * capture_partner?: string,
     * orderby?: string,
     * page?: int,
     * limit?: int
     * } $filters
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function todos(array $filters = []): Response
    {
        $response = $this->httpClient->get('/transacoes', [
            RequestOptions::QUERY => $filters,
        ]);

        return $response->setResponseDto(TransacaoResponseDto::class);
    }

    /**
     * Consultar Parcelas de uma Transação.
     *
     * @param int $transacaoId ID da transação para consultar as parcelas.
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function parcelas(int $transacaoId): Response
    {
        $response = $this->httpClient->get('/transacoes/parcelas', [
            RequestOptions::QUERY => [
                'transacaoId' => $transacaoId,
            ],
        ]);

        return $response->setResponseDto(ParcelaResponseDto::class);
    }
}
