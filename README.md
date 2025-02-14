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
```php
require 'vendor/autoload.php';

use Husail\MovingPay\Client;
use Husail\MovingPay\Authentication;

$client = new Client(
    new Authentication(token: 'your-token', customerId: 'your-customer-id')
);

$response = $client->estabelecimento->getAll();
if ($response->successful()) {
    // Handle the response
}
```

### **For Laravel:**

1. **Publish the configuration**:
   ```bash
   php artisan vendor:publish --provider="Husail\MovingPay\MovingPayServiceProvider"
   ```

2. **Add environment variables** in your `.env` file:
   ```env
   MOVINGPAY_TOKEN=your-token
   MOVINGPAY_CUSTOMER_ID=your-customer-id
   ```

4. **Use the Facade to interact with the API:**

```php
use MovingPay;

$response = MovingPay::client()->estabelecimento->all();
if ($response->successful()) {
    // Handle the response
}
```

---

## 🤝 Contributing
We welcome contributions! Feel free to submit issues or pull requests to help improve the SDK.

---

## 📜 License
Licensed under the [MIT License](LICENSE.md).
