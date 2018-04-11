<?php

use App\User;

return [
    'model' => User::class,
    'table' => 'oauth_identities',
    'custom-providers' => [
        'keycloak' => [
            'client_id' => 'account',
            'client_secret' => env('KEYCLOAK_CLIENT_ACCOUNT_SECRET'),
            'redirect_uri' =>  env('GDM_PROTOCOL') . "://" . env('GDM_URL') .  '/keycloak/callback',
            'scope' => [],
            'provider_class' => App\Providers\OAuth2\KeycloakProvider::class
        ],
    ],
//    'providers' => [
//        'facebook' => [
//            'client_id' => '12345678',
//            'client_secret' => 'y0ur53cr374ppk3y',
//            'redirect_uri' => 'https://example.com/your/facebook/redirect',
//            'scope' => [],
//        ],
//        'google' => [
//            'client_id' => '12345678',
//            'client_secret' => 'y0ur53cr374ppk3y',
//            'redirect_uri' => 'https://example.com/your/google/redirect',
//            'scope' => [],
//        ],
//        'github' => [
//            'client_id' => '12345678',
//            'client_secret' => 'y0ur53cr374ppk3y',
//            'redirect_uri' => 'https://example.com/your/github/redirect',
//            'scope' => [],
//        ],
//        'linkedin' => [
//            'client_id' => '12345678',
//            'client_secret' => 'y0ur53cr374ppk3y',
//            'redirect_uri' => 'https://example.com/your/linkedin/redirect',
//            'scope' => [],
//        ],
//        'instagram' => [
//            'client_id' => '12345678',
//            'client_secret' => 'y0ur53cr374ppk3y',
//            'redirect_uri' => 'https://example.com/your/instagram/redirect',
//            'scope' => [],
//        ],
//        'soundcloud' => [
//            'client_id' => '12345678',
//            'client_secret' => 'y0ur53cr374ppk3y',
//            'redirect_uri' => 'https://example.com/your/soundcloud/redirect',
//            'scope' => [],
//        ],
//    ],
];
