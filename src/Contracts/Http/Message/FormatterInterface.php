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

namespace Husail\MovingPay\Contracts\Http\Message;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface FormatterInterface
{
    /**
     * Formats a request.
     *
     * @param RequestInterface $request
     * @param string|null $uid
     * @return string
     */
    public function formatRequest(RequestInterface $request, ?string $uid): string;

    /**
     * Formats a response.
     *
     * @param ResponseInterface $response
     * @param string|null $uid
     * @param int|null $duration
     * @return string
     */
    public function formatResponse(ResponseInterface $response, ?string $uid, ?int $duration): string;

    /**
     * Formats a request and response together.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param string|null $uid
     * @param int|null $duration in seconds
     * @return string
     */
    public function formatRequestAndResponse(RequestInterface $request, ResponseInterface $response, ?string $uid, ?int $duration): string;
}
