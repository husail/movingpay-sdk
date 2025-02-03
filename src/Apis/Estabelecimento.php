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

use Husail\MovingPay\Dtos\ResultPagerDto;
use Husail\MovingPay\HttpClient\Message\Response;

final class Estabelecimento extends AbstractApi
{
    public function getAll(array $filters = []): Response
    {
        $response = $this->httpClient->get('/estabelecimentos', [
            'query' => $filters,
        ]);

        return $response->setResponseDto(ResultPagerDto::class);
    }
}
