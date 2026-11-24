<?php

declare(strict_types=1);

namespace Husail\MovingPay\Console;

use Husail\MovingPay\Client;
use Illuminate\Console\Command;

final class RefreshMovingPayTokenCommand extends Command
{
    protected $signature = 'movingpay:refresh-token';

    protected $description = 'Refreshes the cached MovingPay access token.';

    public function handle(Client $client): int
    {
        $client->ensureAccessToken();

        return self::SUCCESS;
    }
}
