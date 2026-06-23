<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Microsoft Entra ID (Azure AD) Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration file contains settings for Microsoft Entra ID
    | OAuth2 integration using Laravel Socialite.
    |
    */

    'entra' => [
        'client_id' => env('ENTRA_CLIENT_ID'),
        'client_secret' => env('ENTRA_CLIENT_SECRET'),
        'redirect' => env('ENTRA_REDIRECT_URI'),
        'tenant_id' => env('ENTRA_TENANT_ID', 'common'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Entra ID OAuth Endpoints
    |--------------------------------------------------------------------------
    |
    | Do not modify these unless you're using a different Azure environment.
    |
    */

    'entra_endpoints' => [
        'authorize' => 'https://login.microsoftonline.com/:tenant/oauth2/v2.0/authorize',
        'token' => 'https://login.microsoftonline.com/:tenant/oauth2/v2.0/token',
        'profile' => 'https://graph.microsoft.com/v1.0/me',
    ],

    /*
    |--------------------------------------------------------------------------
    | Scopes for Entra ID
    |--------------------------------------------------------------------------
    |
    | The scopes requested from Entra ID during authentication.
    |
    */

    'scopes' => [
        'openid',
        'profile',
        'email',
        'User.Read',
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto User Provisioning
    |--------------------------------------------------------------------------
    |
    | When enabled, new users will be automatically created on their first
    | Entra ID login if they don't already exist in the system.
    |
    */

    'auto_provision_users' => env('ENTRA_AUTO_PROVISION_USERS', true),

    /*
    |--------------------------------------------------------------------------
    | Sync Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for syncing users from Entra ID directory.
    |
    */

    'sync' => [
        'enabled' => env('ENTRA_SYNC_ENABLED', true),
        'batch_size' => env('ENTRA_SYNC_BATCH_SIZE', 100),
        'update_existing' => env('ENTRA_SYNC_UPDATE_EXISTING', true),
    ],
];
