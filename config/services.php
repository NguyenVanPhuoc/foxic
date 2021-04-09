<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_APP_ID'), #772294663643753
        'client_secret' => env('FACEBOOK_APP_SECRET'), #5642b54a684d1e219e8838173ae8c673
        'redirect' => env('FACEBOOK_APP_CALLBACK_URL'), #https://foxic.vn/social/callback/facebook
    ],

    'google' => [
        'client_id' => env('GOOGLE_APP_ID'), #682533323810-lne3hmaojkj5fv59mdecjb6ue2otkrd9.apps.googleusercontent.com
        'client_secret' => env('GOOGLE_APP_SECRET'), #7DKVWmwab2aI8YPFhfAm7q3h
        'redirect' => env('GOOGLE_APP_CALLBACK_URL'),
    ],
];
