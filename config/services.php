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
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
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

    'nuclea' => [
        'mode' => env('NUCLEA_SANDBOX_MODE'),
        'base_url' => env('NUCLEA_SANDBOX_MODE') ? env('NUCLEA_SANDBOX_BASE_URL') : env('NUCLEA_PRODUCTION_BASE_URL'),
        'participant' => [
            'identifier' => env('NUCLEA_PARTICIPANT_IDENTIFIER'),
            'certificate_private_key' => env('NUCLEA_PARTICIPANT_CERTIFICATE_PRIVATE_KEY'),
            'certificate_finger_print' => env('NUCLEA_PARTICIPANT_CERTIFICATE_FINGER_PRINT'),
            'certificate_serial_number' => env('NUCLEA_PARTICIPANT_CERTIFICATE_SERIAL_NUMBER'),
        ],
    ],

    'rtm' => [
        'webhook_token' => env('RTM_WEBHOOK_TOKEN'),
        'base_url' => env('RTM_BASE_URL'),
        'username' => env('RTM_USERNAME'),
        'password' => env('RTM_PASSWORD'),
    ],
];
