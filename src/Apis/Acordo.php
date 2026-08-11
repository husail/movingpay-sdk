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
use Husail\MovingPay\Dtos\Acordo\AcordoPaginacaoDto;

final class Acordo extends AbstractApi
{
    /**
     * Consultar acordos do estabelecimento.
     *
     * Filtros disponíveis:
     * - `merchant_id` (string, obrigatório): Código de identificação do estabelecimento. Não pode ser vazio.
     * - `rate_id` (string, opcional): Código do plano ao qual o acordo está vinculado.
     * - `acquirer_id` (string, opcional): Código da adquirente:
     *   - `5`: Rede S/A
     *   - `17`: Adiq
     *   - `18`: Pagseguro
     *   - `19`: Global Payments
     *   - `20`: Cielo S/A
     *   - `38166`: PIX
     * - `mcc` (string, opcional): Código MCC ao qual o acordo está vinculado.
     *
     * @param array{
     *     merchant_id: non-empty-string,
     *     rate_id?: string,
     *     acquirer_id?: string,
     *     mcc?: string
     * } $filters
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function todos(array $filters): Response
    {
        $response = $this->httpClient->get('/acordos', [
            RequestOptions::QUERY => $filters,
        ]);

        return $response->setResponseDto(AcordoPaginacaoDto::class);
    }
}
