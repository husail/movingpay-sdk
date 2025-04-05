# MovingPay PHP SDK
The **MovingPay PHP SDK** allows integration with the MovingPay API in **any PHP project**. It also provides **Facades** and a **Service Provider** for enhanced **Laravel** integration.

---

## 📦 Installation
```bash
composer require husail/movingpay-sdk
```

---

## 🔧 Usage Example

### **For Non-Laravel PHP Projects:**
**Basic Usage:**
```php
require 'vendor/autoload.php';

use Husail\MovingPay\Client;
use Husail\MovingPay\Authentication;

$client = new Client(
    new Authentication(token: 'your-token', customerId: 'your-customer-id')
);

$response = $client->estabelecimento->all();
if ($response->successful()) {
    // Handle the response
}
```
**With Logging:**
```php
require 'vendor/autoload.php';

use Monolog\Logger;
use Husail\MovingPay\Client;
use Monolog\Handler\StreamHandler;
use Husail\MovingPay\Authentication;
use Husail\MovingPay\HttpClient\Message\Formatter\SimpleFormatter;

$logger = new Logger('my_logger');
$logger->pushHandler(new StreamHandler(__DIR__ . '/movingpay.log'));

$client = new Client(
    new Authentication(token: 'your-token', customerId: 'your-customer-id'),
    logger: $logger,
    formatter: new SimpleFormatter(true) // 'true' enables pretty-printed JSON logs
);

$response = $client->estabelecimento->all();
if ($response->successful()) {
    // Handle the response
}
```

---

### **For Laravel:**

1. **Publish the configuration**:
   ```bash
   php artisan vendor:publish --provider="Husail\MovingPay\MovingPayServiceProvider"
   ```

2. **Add environment variables** in your `.env` file:
   ```env
   MOVINGPAY_TOKEN=your-token
   MOVINGPAY_CUSTOMER_ID=your-customer-id
   
   # Optional logging settings:
   MOVINGPAY_LOG_ENABLED=false             # Enable or disable request/response logging
   MOVINGPAY_LOG_FORMATTER_EXPANDED=false  # Pretty-print JSON in logs if enabled
   ```

3. **Use the Facade to interact with the API:**
```php
use MovingPay;

$response = MovingPay::client()->estabelecimento->all();
if ($response->successful()) {
    // Handle the response
}
```

4. **Configure Logging**
    
   When `MOVINGPAY_LOG_ENABLED` is set to `true`, the SDK logs request and response details via Laravel's default logging channel. By default, logs output compact JSON. If you want the JSON output to be more readable (pretty-printed), set `MOVINGPAY_LOG_FORMATTER_EXPANDED` to `true`.

---

## 🤝 Contributing
We welcome contributions! Feel free to submit issues or pull requests to help improve the SDK.

---

## 📜 License
Licensed under the [MIT License](LICENSE.md).
