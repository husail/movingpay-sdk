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

namespace Husail\MovingPay\HttpClient;

use Http\Client\Common\Plugin;
use Psr\Http\Client\ClientInterface;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Client\Common\PluginClientFactory;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * Class Builder
 *
 * The Builder class is responsible for constructing an HTTP client with
 * customizable plugins. This allows for flexible configuration of HTTP
 * clients tailored to the needs of the application using the MovingPay SDK.
 *
 * Key features of the Builder:
 * - Automatic discovery of HTTP client, request factory, and stream factory.
 * - Ability to add plugins to the HTTP client for enhanced functionality.
 * - Lazy initialization of the HTTP client with plugins to ensure efficient resource usage.
 */
final class Builder
{
    /**
     * The object that sends HTTP messages.
     *
     * @var ClientInterface
     */
    private ClientInterface $httpClient;

    /**
     * The HTTP request factory.
     *
     * @var RequestFactoryInterface
     */
    private RequestFactoryInterface $requestFactory;

    /**
     * The HTTP stream factory.
     *
     * @var StreamFactoryInterface
     */
    private StreamFactoryInterface $streamFactory;

    /**
     * A HTTP client with all our plugins.
     *
     * @var HttpMethodsClient|null
     */
    private ?HttpMethodsClient $pluginClient;

    /**
     * The currently registered plugins.
     *
     * @var array
     */
    private array $plugins = [];

    /**
     * Create a new http client builder instance.
     *
     * @param ClientInterface|null $httpClient
     * @param RequestFactoryInterface|null $requestFactory
     * @param StreamFactoryInterface|null $streamFactory
     */
    public function __construct(
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null
    ) {
        $this->httpClient = $httpClient ?: Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = $streamFactory ?: Psr17FactoryDiscovery::findStreamFactory();
    }

    /**
     * Add a new plugin to the end of the plugin chain.
     *
     * @param Plugin $plugin
     * @return void
     */
    public function addPlugin(Plugin $plugin): void
    {
        $this->plugins[] = $plugin;
        $this->pluginClient = null;
    }

    /**
     * Remove a plugin by its fully qualified class name (FQCN).
     *
     * @param string $fqcn
     * @return void
     */
    public function removePlugin(string $fqcn): void
    {
        foreach ($this->plugins as $idx => $plugin) {
            if ($plugin instanceof $fqcn) {
                unset($this->plugins[$idx]);
                $this->pluginClient = null;
            }
        }
    }

    /**
     * Get the HTTP client with all plugins applied.
     *
     * @return HttpMethodsClient
     */
    public function getHttpClient(): HttpMethodsClient
    {
        if ($this->pluginClient === null) {
            $this->pluginClient = new HttpMethodsClient(
                (new PluginClientFactory())->createClient($this->httpClient, $this->plugins),
                $this->requestFactory,
                $this->streamFactory
            );
        }

        return $this->pluginClient;
    }
}
