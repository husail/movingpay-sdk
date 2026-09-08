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
use Husail\MovingPay\HttpClient\Message\Response;
use Husail\MovingPay\Dtos\CategoriaMcc\CategoriaMccResponseDto;

final class CategoriaMcc extends AbstractApi
{
    /**
     * Consultar categorias MCC.
     *
     * Essa rota retorna um array de objetos contendo informações sobre todos os CNAEs cadastrados,
     * ordenados por ordem de data de cadastro, iniciando pelo mais recente.
     *
     * @return Response
     *
     * @throws ClientExceptionInterface
     */
    public function todos(): Response
    {
        $response = $this->httpClient->get('/tabelas/cnae');

        return $response->setResponseDto(CategoriaMccResponseDto::class);
    }
}
