<?php

return [
    'organization_id_sandbox' => env('ORGANIZATION_ID_SANDBOX'),
    'organization_id_production' => env('ORGANIZATION_ID_PRODUCTION'),

    // Automatically pick based on environment
    'organization_id' => env('APP_ENV') === 'production'
        ? env('SS_ORGANIZATION_ID_PRODUCTION')
        : env('SS_ORGANIZATION_ID_SANDBOX'),

	'base_url' => env('APP_ENV') === 'production'
        ? env('SS_BASE_URL_PRODUCTION')
        : env('SS_BASE_URL_SANDBOX'),

	'auth_url' => env('APP_ENV') === 'production'
		? env('SS_AUTH_URL_PRODUCTION')
		: env('SS_AUTH_URL_SANDBOX'),

	'client_id' => env('APP_ENV') === 'production'
        ? env('SS_CLIENT_ID_PRODUCTION')
        : env('SS_CLIENT_ID_SANDBOX'),

	'client_secret' => env('APP_ENV') === 'production'
		? env('SS_CLIENT_SECRET_PRODUCTION')
		: env('SS_CLIENT_SECRET_SANDBOX'),

];
