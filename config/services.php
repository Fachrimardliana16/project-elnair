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

    // ─── Advertising & Analytics Pixel IDs ───────────────────────────────
    // Set these in your .env file. They are read by the <x-advertising-pixels />
    // blade component loaded in the global layout head.
    'pixels' => [
        'meta_pixel_id'  => env('META_PIXEL_ID'),
        'gtm_id'         => env('GOOGLE_TAG_MANAGER_ID'),
        'ga4_id'         => env('GA4_MEASUREMENT_ID'),
        'tiktok_pixel_id'=> env('TIKTOK_PIXEL_ID'),
        'google_ads_id'  => env('GOOGLE_ADS_ID'),
    ],

];
