<?php

return [
    'oidc' => [
        'client_id' => env('DATEV_OIDC_CLIENT_ID'),
        'client_secret' => env('DATEV_OIDC_CLIENT_SECRET'),
        'redirect' => env('DATEV_OIDC_CALLBACK_URL', 'http://localhost:8000/auth/callback'),
        'sandbox' => [
            'issuer' => env('DATEV_OIDC_SANDBOX_ISSUER', 'https://login.datev.de/openidsandbox'),
            'jwks_uri' => env('DATEV_OIDC_SANDBOX_JWKS_URI', 'https://sandbox-api.datev.de/certs'),
            'authorization_endpoint' => env('DATEV_OIDC_SANDBOX_AUTHORIZATION_ENDPOINT', 'https://login.datev.de/openidsandbox/authorize'),
            'token_endpoint' => env('DATEV_OIDC_SANDBOX_TOKEN_ENDPOINT', 'https://sandbox-api.datev.de/token'),
            'userinfo_endpoint' => env('DATEV_OIDC_SANDBOX_USERINFO_ENDPOINT', 'https://sandbox-api.datev.de/userinfo'),
            'revocation_endpoint' => env('DATEV_OIDC_SANDBOX_REVOCATION_ENDPOINT', 'https://sandbox-api.datev.de/revoke'),
            'check_session_iframe' => env('DATEV_OIDC_SANDBOX_CHECK_SESSION_IFRAME', 'https://sandbox-api.datev.de/checksession'),
            'end_session_endpoint' => env('DATEV_OIDC_SANDBOX_END_SESSION_ENDPOINT', 'https://sandbox-api.datev.de/endsession'),
            'response_types_supported' => [
                'code',
                'id_token',
                'id_token token',
                'code id_token',
            ],
            'subject_types_supported' => [
                'pairwise',
            ],
            'id_token_signing_alg_values_supported' => [
                'RS256',
            ],
        ],
        'production' => [
            'issuer' => env('DATEV_OIDC_PRODUCTION_ISSUER', 'https://login.datev.de/openid'),
            'jwks_uri' => env('DATEV_OIDC_PRODUCTION_JWKS_URI', 'https://api.datev.de/certs'),
            'authorization_endpoint' => env('DATEV_OIDC_PRODUCTION_AUTHORIZATION_ENDPOINT', 'https://login.datev.de/openid/authorize'),
            'token_endpoint' => env('DATEV_OIDC_PRODUCTION_TOKEN_ENDPOINT', 'https://api.datev.de/token'),
            'userinfo_endpoint' => env('DATEV_OIDC_PRODUCTION_USERINFO_ENDPOINT', 'https://api.datev.de/userinfo'),
            'revocation_endpoint' => env('DATEV_OIDC_PRODUCTION_REVOCATION_ENDPOINT', 'https://api.datev.de/revoke'),
            'check_session_iframe' => env('DATEV_OIDC_PRODUCTION_CHECK_SESSION_IFRAME', 'https://api.datev.de/checksession'),
            'end_session_endpoint' => env('DATEV_OIDC_PRODUCTION_END_SESSION_ENDPOINT', 'https://api.datev.de/endsession'),
            'response_types_supported' => [
                'code',
                'id_token',
                'id_token token',
                'code id_token',
            ],
            'subject_types_supported' => [
                'pairwise',
            ],
            'id_token_signing_alg_values_supported' => [
                'RS256',
            ],
        ],
    ],
    'dxso_jobs' => [
        'use_sandbox' => env('DATEV_DXSO_JOBS_USE_SANDBOX', true),
        'sandbox_api_url' => env('DATEV_DXSO_JOBS_SANDBOX_API_URL', 'https://accounting-dxso-jobs.api.datev.de/platform-sandbox/v2'),
        'api_url' => env('DATEV_DXSO_JOBS_API_URL', 'https://accounting-dxso-jobs.api.datev.de/platform/v2'),
    ],
];
