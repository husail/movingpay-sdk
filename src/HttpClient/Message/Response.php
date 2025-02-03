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

namespace Husail\MovingPay\HttpClient\Message;

use CuyZ\Valinor\MapperBuilder;
use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use Psr\Http\Message\ResponseInterface;
use Husail\MovingPay\HttpClient\Util\Arr;
use Husail\MovingPay\Contracts\DtoInterface;
use CuyZ\Valinor\Mapper\Source\Exception\InvalidSource;

class Response
{
    /**
     * The PSR-7 response object.
     *
     * @var ResponseInterface
     */
    protected ResponseInterface $response;

    /**
     * The signature of the Data Transfer Object (DTO) to map the response to.
     *
     * @var string|null
     */
    protected ?string $signatureDto;

    /**
     * The decoded JSON response.
     *
     * @var array|null
     */
    protected ?array $decoded;

    public function __construct(ResponseInterface $response, ?string $signatureDto = null)
    {
        $this->response = $response;
        $this->signatureDto = $signatureDto;
        $this->decoded = null;
    }

    /**
     * Get a header from the response.
     *
     * @param string $header
     * @return string
     */
    public function header(string $header): string
    {
        return $this->response->getHeaderLine($header);
    }

    /**
     * Get the headers from the response.
     *
     * @return array
     */
    public function headers(): array
    {
        return $this->response->getHeaders();
    }

    /**
     * Get the reason phrase of the response.
     *
     * @return string
     */
    public function reason(): string
    {
        return $this->response->getReasonPhrase();
    }

    /**
     * Get the status code of the response.
     *
     * @return int
     */
    public function status(): int
    {
        return $this->response->getStatusCode();
    }

    /**
     * Determine if the request was successful.
     *
     * @return bool
     */
    public function successful(): bool
    {
        return $this->status() >= 200 && $this->status() < 300;
    }

    /**
     * Determine if the response was a redirect.
     *
     * @return bool
     */
    public function redirect(): bool
    {
        return $this->status() >= 300 && $this->status() < 400;
    }

    /**
     * Determine if the response indicates a client error occurred.
     *
     * @return bool
     */
    public function clientError(): bool
    {
        return $this->status() >= 400 && $this->status() < 500;
    }

    /**
     * Determine if the response indicates a server error occurred.
     *
     * @return bool
     */
    public function serverError(): bool
    {
        return $this->status() >= 500;
    }

    /**
     * Determine if the response indicates a client or server error occurred.
     *
     * @return bool
     */
    public function failed(): bool
    {
        return $this->serverError() || $this->clientError();
    }

    /**
     * Get the body of the response.
     *
     * @return string
     */
    public function body(): string
    {
        $this->response->getBody()->rewind();

        return $this->response->getBody()->getContents();
    }

    /**
     * Get the JSON decoded body of the response as an array or scalar value.
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function json(?string $key = null, mixed $default = null): mixed
    {
        if (!$this->decoded) {
            $this->decoded = json_decode($this->body(), true);
        }

        if (is_null($key)) {
            return $this->decoded;
        }

        return Arr::get($this->decoded, $key, $default);
    }

    /**
     * Get the JSON decoded body of the response as an object.
     *
     * @param string|null $signatureDto
     * @return \stdClass|DtoInterface
     *
     * @throws InvalidSource
     * @throws MappingError
     */
    public function object(?string $signatureDto = null): \stdClass|DtoInterface
    {
        $signatureDto = $signatureDto ?? $this->signatureDto;
        if (empty($signatureDto)) {
            return json_decode($this->body(), false);
        }

        return (new MapperBuilder())
            ->allowPermissiveTypes()
            ->allowSuperfluousKeys()
            ->mapper()
            ->map($signatureDto, Source::json($this->body())->camelCaseKeys());
    }

    /**
     * Set or update the DTO signature for the response.
     *
     * @param string|null $signatureDto
     * @return Response
     */
    public function setResponseDto(?string $signatureDto = null): Response
    {
        $this->signatureDto = $signatureDto;

        return $this;
    }
}
