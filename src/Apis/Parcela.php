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

use Husail\MovingPay\Dtos\Parcela\ParcelaResponseDto;
use Husail\MovingPay\HttpClient\Message\Response;
use Husail\MovingPay\HttpClient\RequestOptions;
use Psr\Http\Client\ClientExceptionInterface;

final class Parcela extends AbstractApi
{
    /**
     * Consultar parcelas.
     *
     * @param array{
     *     page?: int,
     *     limit?: int,
     *     start_date?: string,
     *     finish_date?: string,
     *     filter_date_by?: string,
     *     tipoProduto?: string,
     *     statusAdquirente?: int,
     *     codigoUnidadeNegocios?: int
     * } $filters
     * @throws ClientExceptionInterface
     */
    public function todos(array $filters = []): Response
    {
        $response = $this->httpClient->get('/parcelas', [
            RequestOptions::QUERY => $filters,
        ]);

        return $response->setResponseDto(ParcelaResponseDto::class);
    }
}
