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

namespace Husail\MovingPay\HttpClient\Message\Formatter;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Husail\MovingPay\Contracts\Http\Message\FormatterInterface;

class SimpleFormatter implements FormatterInterface
{
    /**
     * JSON encoding options for pretty printing and preserving slashes and unicode characters
     *
     * @var int
     */
    private const JSON_ENCODE_OPTIONS = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;

    /**
     * Determines if the JSON output should be expanded (pretty printed)
     *
     * @var bool
     */
    private bool $outputExpanded;

    /**
     * Regex for detecting binary bodies
     *
     * @var string
     */
    private string $binaryDetectionRegex;

    /**
     * Instantiate a new SimpleFormatter.
     *
     * @param bool $outputExpanded - Determines if the JSON output should be expanded
     * @param string $binaryDetectionRegex - Regex for detecting binary bodies
     */
    public function __construct(bool $outputExpanded = true, string $binaryDetectionRegex = '/([\x00-\x09\x0C\x0E-\x1F\x7F])/')
    {
        $this->outputExpanded = $outputExpanded;
        $this->binaryDetectionRegex = $binaryDetectionRegex;
    }

    /**
     * Formats the HTTP request into a readable string
     *
     * @param RequestInterface $request - The HTTP request
     * @param string|null $uid - Unique ID of the request
     * @return string - Formatted request
     */
    public function formatRequest(RequestInterface $request, ?string $uid): string
    {
        $headers = json_encode($request->getHeaders(), $this->outputExpanded ? self::JSON_ENCODE_OPTIONS : 0);

        return sprintf(
            "Request:\nUID: %s\nMethod: %s\nURI: %s\nHeaders: %s\nBody: %s\n",
            $uid ?: 'N/A',
            $request->getMethod(),
            $request->getUri(),
            $headers,
            $this->formatMessageBody($request)
        );
    }

    /**
     * Formats the HTTP response into a readable string
     *
     * @param ResponseInterface $response - The HTTP response
     * @param string|null $uid - Unique ID of the request
     * @param int|null $duration - Duration of the request
     * @return string - Formatted response
     */
    public function formatResponse(ResponseInterface $response, ?string $uid, ?int $duration): string
    {
        return sprintf(
            "Response:\nUID: %s\nStatus Code: %s\nReason Phrase: %s\nDuration: %d ms\nBody: %s\n",
            $uid ?: 'N/A',
            $response->getStatusCode(),
            $response->getReasonPhrase(),
            $duration ?: 0,
            $this->formatMessageBody($response)
        );
    }

    /**
     * Formats both the HTTP request and response into a readable string
     *
     * @param RequestInterface $request - The HTTP request
     * @param ResponseInterface $response - The HTTP response
     * @param string|null $uid - Unique ID of the request
     * @param int|null $duration - Duration of the request
     * @return string - Formatted request and response
     */
    public function formatRequestAndResponse(RequestInterface $request, ResponseInterface $response, ?string $uid, ?int $duration): string
    {
        $jsonEncodeOptions = $this->outputExpanded ? self::JSON_ENCODE_OPTIONS : 0;

        $requestDetails = json_encode([
            'method' => $request->getMethod(),
            'uri' => (string) $request->getUri(),
            'headers' => $request->getHeaders(),
            'body' => $this->formatMessageBody($request),
        ], $jsonEncodeOptions);
        $responseDetails = json_encode([
            'statusCode' => $response->getStatusCode(),
            'reasonPhrase' => $response->getReasonPhrase(),
            'headers' => $response->getHeaders(),
            'body' => $this->formatMessageBody($response),
        ], $jsonEncodeOptions);

        return sprintf(
            "%s %s %s\nUID: %s\nDuration: %d ms\nRequest: %s\nResponse: %s\n",
            $request->getMethod(),
            $request->getUri(),
            $response->getStatusCode(),
            $uid ?: 'N/A',
            $duration ?: 0,
            $requestDetails,
            $responseDetails
        );
    }

    /**
     * Formats the message body, omitting large bodies
     *
     * @param MessageInterface $message - The HTTP message (request or response)
     * @return string - Formatted message body
     */
    private function formatMessageBody(MessageInterface $message): string
    {
        $messageFormatted = '';
        $streamContent = $message->getBody()->getContents();
        $message->getBody()->rewind();

        if (preg_match($this->binaryDetectionRegex, $streamContent)) {
            return $messageFormatted . '[Binary Body Omitted]';
        }

        return $messageFormatted . $streamContent;
    }
}
