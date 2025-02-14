<?php

return [
    'token' => env('MOVINGPAY_TOKEN'),
    'customer_id' => env('MOVINGPAY_CUSTOMER_ID'),
    'log_enabled' => env('MOVINGPAY_LOG_ENABLED', false),
    'log_formatter_expanded' => env('MOVINGPAY_LOG_FORMATTER_EXPANDED', false),
];
