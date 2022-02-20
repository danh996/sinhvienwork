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
    'google' => [
        'client_id' => '26194227340-6bdhpbta80p4iioqjslue9c1ci1oc628.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'https://akamoni.xyz/login/employer/google/callback'
    ],
    'facebook' => [
        'client_id' => '1170873236988527',
        'client_secret' => '95bea9ea99c2f9eac1281485fed10cb3',
        'redirect' => 'https://akamoni.xyz/login/employer/facebook/callback'
    ],
];
