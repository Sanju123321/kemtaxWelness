<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'twilio' => [
    'sid'   => env('TWILIO_SID'),
    'token' => env('TWILIO_TOKEN'),
    'from'  => env('TWILIO_FROM'),
],
'razorpay' => [
    'key' => env('RAZORPAY_KEY_ID'),
    'secret' => env('RAZORPAY_KEY_SECRET'),
    'x_key' => env('RAZORPAYX_KEY_ID', env('RAZORPAY_KEY_ID')),
    'x_secret' => env('RAZORPAYX_KEY_SECRET', env('RAZORPAY_KEY_SECRET')),
    'x_account_number' => env('RAZORPAYX_ACCOUNT_NUMBER'),
    'x_base_url' => env('RAZORPAYX_BASE_URL', 'https://api.razorpay.com/v1'),
],
];
