<?php

return [
    'base_uri' => env('MOVINGPAY_BASE_URI', 'https://api-backoffice-mtls.movingpay.com.br/api/v3'),
    'token_uri' => env('MOVINGPAY_TOKEN_URI', 'https://sso.movingpay.com.br/realms/prd-movingpay/protocol/openid-connect/token'),
    'client_id' => env('MOVINGPAY_CLIENT_ID'),
    'client_secret' => env('MOVINGPAY_CLIENT_SECRET'),
    'mtls_cert' => env('MOVINGPAY_MTLS_CERT'),
    'mtls_key' => env('MOVINGPAY_MTLS_KEY'),
    'mtls_ca_bundle' => env('MOVINGPAY_MTLS_CA_BUNDLE'),
    'token_cache_store' => env('MOVINGPAY_TOKEN_CACHE_STORE'),
    'token_cache_key' => env('MOVINGPAY_TOKEN_CACHE_KEY', 'movingpay:access-token'),
    'token_refresh_skew' => env('MOVINGPAY_TOKEN_REFRESH_SKEW', 60),
    'log_enabled' => env('MOVINGPAY_LOG_ENABLED', false),
    'log_formatter_expanded' => env('MOVINGPAY_LOG_FORMATTER_EXPANDED', false),
];
