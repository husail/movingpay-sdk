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

namespace Husail\MovingPay\HttpClient\Plugin;

use Http\Promise\Promise;
use Http\Client\Exception;
use Psr\Log\LoggerInterface;
use Http\Client\Common\Plugin;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Husail\MovingPay\Contracts\Http\Message\FormatterInterface;
use Husail\MovingPay\HttpClient\Message\Formatter\SimpleFormatter;

final class LoggerPlugin implements Plugin
{
    /**
     * The name of the package using this plugin
     *
     * @var string
     */
    private string $packageName;

    /**
     * Logger interface for logging messages
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * FormatterInterface interface for formatting requests and responses
     *
     * @var FormatterInterface
     */
    private FormatterInterface $formatter;

    /**
     * Determines whether to log request and response together
     *
     * @var bool
     */
    private bool $outputTogether;

    /**
     * Instantiate a new Logger Plugin.
     *
     * @param string $packageName - The name of the package using this plugin
     * @param LoggerInterface $logger - Logger interface for logging messages
     * @param FormatterInterface|null $formatter - FormatterInterface interface for formatting requests and responses
     * @param bool $outputTogether - Determines whether to log request and response together
     */
    public function __construct(string $packageName, LoggerInterface $logger, ?FormatterInterface $formatter = null, bool $outputTogether = true)
    {
        $this->packageName = $packageName;
        $this->logger = $logger;
        $this->formatter = $formatter ?: new SimpleFormatter();
        $this->outputTogether = $outputTogether;
    }

    /**
     * Handles the HTTP request and logs the request and response
     *
     * @param RequestInterface $request - The HTTP request
     * @param callable $next - The next middleware to call
     * @param callable $first - The first middleware to call
     * @return Promise - A promise representing the result of the middleware execution
     *
     * @throws Exception
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $uid = uniqid('');
        $startTime = hrtime(true) / 1E6;

        // Logs the request separately if not configured to output together.
        if (!$this->outputTogether) {
            $this->logger->info(sprintf('[%s] %s', $this->packageName, $this->formatter->formatRequest($request, $uid)));
        }

        return $next($request)->then(function (ResponseInterface $response) use ($uid, $startTime, $request) {
            $this->logResponse($request, $response, $uid, $startTime);

            return $response;
        }, function (Exception $exception) use ($uid, $startTime, $request) {
            $this->logException($exception, $request, $uid, $startTime);

            throw $exception;
        });
    }

    /**
     * Logs the HTTP response
     *
     * @param RequestInterface $request - The HTTP request
     * @param ResponseInterface $response - The HTTP response
     * @param string $uid - Unique ID of the request
     * @param float $startTime - Start time of the request
     */
    private function logResponse(RequestInterface $request, ResponseInterface $response, string $uid, float $startTime): void
    {
        $duration = (int) round(hrtime(true) / 1E6 - $startTime);
        $formattedResponse = $this->outputTogether
            ? $this->formatter->formatRequestAndResponse($request, $response, $uid, $duration)
            : $this->formatter->formatResponse($response, $uid, $duration);

        $this->logger->info(sprintf('[%s] %s', $this->packageName, $formattedResponse));
    }

    /**
     * Logs the exception that occurred during the request
     *
     * @param Exception $exception - The exception that occurred
     * @param RequestInterface $request - The HTTP request
     * @param string $uid - Unique ID of the request
     * @param float $startTime - Start time of the request
     */
    private function logException(Exception $exception, RequestInterface $request, string $uid, float $startTime): void
    {
        $duration = (int) round(hrtime(true) / 1E6 - $startTime);
        if ($exception instanceof Exception\HttpException) {
            $formattedResponse = $this->outputTogether
                ? $this->formatter->formatRequestAndResponse($exception->getRequest(), $exception->getResponse(), $uid, $duration)
                : $this->formatter->formatResponse($exception->getResponse(), $uid, $duration);
            $this->logger->error(sprintf(
                "[%s] Error:\n%s\nwith response:\n%s",
                $this->packageName,
                $exception->getMessage(),
                $formattedResponse
            ));
        } else {
            $this->logger->error(sprintf(
                "[%s] Error:\n%s\nwhen sending request:\n%s",
                $this->packageName,
                $exception->getMessage(),
                $this->formatter->formatRequest($request, $uid)
            ));
        }
    }
}
