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
use Husail\MovingPay\Dtos\Dispositivo\ModeloPaginacaoDto;
use Husail\MovingPay\Dtos\Dispositivo\FabricantePaginacaoDto;
use Husail\MovingPay\Dtos\Dispositivo\DispositivoPaginacaoDto;

final class Dispositivo extends AbstractApi
{
    /**
     * Consultar dispositivos.
     *
     * @param array{
     *     page?: int,
     *     codigo_estabelecimento?: int|string,
     *     numero_serie?: string,
     *     situacao?: int,
     *     limit?: int
     * } $filters Filtros opcionais da consulta
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function todos(array $filters = []): Response
    {
        $response = $this->httpClient->get('/dispositivos', [
            RequestOptions::QUERY => $filters,
        ]);

        return $response->setResponseDto(DispositivoPaginacaoDto::class);
    }

    /**
     * Consultar fabricantes de dispositivos.
     *
     * @param array{
     *     situacao?: int,
     *     page?: int,
     *     limit?: int
     * } $filters Filtros opcionais da consulta
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function fabricantes(array $filters = []): Response
    {
        $response = $this->httpClient->get('/dispositivos/fabricantes/listar', [
            RequestOptions::QUERY => $filters,
        ]);

        return $response->setResponseDto(FabricantePaginacaoDto::class);
    }

    /**
     * Consultar modelos de dispositivos.
     *
     * @param array{
     *     tecnologia?: string,
     *     situacao?: int,
     *     page?: int,
     *     limit?: int
     * } $filters Filtros opcionais da consulta
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function modelos(array $filters = []): Response
    {
        $response = $this->httpClient->get('/dispositivos/modelos/listar', [
            RequestOptions::QUERY => $filters,
        ]);

        return $response->setResponseDto(ModeloPaginacaoDto::class);
    }
}
