# MovingPay PHP SDK

PHP SDK for the MovingPay Backoffice API using OAuth 2.0 client credentials and mTLS.

## Requirements

- PHP 8.1+
- PHP cURL extension with OpenSSL 1.1.1+ support
- A MovingPay `client_id` and `client_secret`
- The mTLS certificate (`.pem`) issued by MovingPay and its matching private key (`.key`)
- An authorized public outbound IP address

Never commit the certificate, private key, access tokens, or client secret.

## Installation

```bash
composer require husail/movingpay-sdk
```

## PHP usage

```php
use Husail\MovingPay\Client;
use Husail\MovingPay\Configuration\ClientCredentialsConfiguration;
use Husail\MovingPay\Configuration\MovingPayConfiguration;
use Husail\MovingPay\Configuration\MtlsConfiguration;

$configuration = new MovingPayConfiguration(
    credentials: new ClientCredentialsConfiguration(
        clientId: $_ENV['MOVINGPAY_CLIENT_ID'],
        clientSecret: $_ENV['MOVINGPAY_CLIENT_SECRET'],
    ),
    mtls: new MtlsConfiguration(
        certificatePath: '/run/secrets/movingpay-client.pem',
        privateKeyPath: '/run/secrets/movingpay-client.key',
    ),
);

$client = new Client($configuration);
$response = $client->estabelecimento->todos();
```

The SDK obtains and caches an access token automatically. Pass a PSR-16 cache implementation as the fifth argument to `Client` to share tokens between processes.

## Laravel

Publish the configuration:

```bash
php artisan vendor:publish --provider="Husail\MovingPay\MovingPayServiceProvider"
```

Configure the environment:

```dotenv
MOVINGPAY_BASE_URI=https://api-backoffice-mtls.movingpay.com.br/api/v3
MOVINGPAY_TOKEN_URI=https://sso.movingpay.com.br/realms/prd-movingpay/protocol/openid-connect/token
MOVINGPAY_CLIENT_ID=
MOVINGPAY_CLIENT_SECRET=
MOVINGPAY_MTLS_CERT=/run/secrets/movingpay-client.pem
MOVINGPAY_MTLS_KEY=/run/secrets/movingpay-client.key
MOVINGPAY_MTLS_CA_BUNDLE=

# Optional shared token cache
MOVINGPAY_TOKEN_CACHE_STORE=redis
MOVINGPAY_TOKEN_CACHE_KEY=movingpay:access-token
MOVINGPAY_TOKEN_REFRESH_SKEW=60
```

Refresh the cached token proactively:

```bash
php artisan movingpay:refresh-token
```

Schedule it in the consuming application:

```php
Schedule::command('movingpay:refresh-token')->everyMinute()->withoutOverlapping();
```

The SDK still refreshes a missing or expired token on demand, so the scheduler is not a single point of failure.

## Migration from static tokens

Static `MOVINGPAY_TOKEN`, `MOVINGPAY_CUSTOMER_ID`, `Authentication`, and the `Customer` header are no longer supported. Configure OAuth credentials and mTLS paths instead.

## Security

TLS server verification is always enabled. The built-in log formatter redacts authorization headers and OAuth token fields. Configure certificates outside public application directories and rotate them before their MovingPay expiration date.

## License

Licensed under the [MIT License](LICENSE.md).
