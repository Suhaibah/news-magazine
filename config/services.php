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

    'news' => [
        'rss_url' => env('NEWS_RSS_URL', 'https://news.google.com/rss?hl=ms-MY&gl=MY&ceid=MY:ms'),
        'max_posts' => env('NEWS_MAX_POSTS', 100),
        'feeds' => [
            [
                'name' => 'Malaysia',
                'url' => env('NEWS_RSS_URL', 'https://news.google.com/rss?hl=ms-MY&gl=MY&ceid=MY:ms'),
            ],
            [
                'name' => 'Bernama',
                'url' => 'https://news.google.com/rss/search?q=site%3Abernama.com%20Malaysia&hl=ms-MY&gl=MY&ceid=MY:ms',
            ],
            [
                'name' => 'Astro Awani',
                'url' => 'https://news.google.com/rss/search?q=site%3Aastroawani.com%20Malaysia&hl=ms-MY&gl=MY&ceid=MY:ms',
            ],
            [
                'name' => 'Sinar Harian',
                'url' => 'https://news.google.com/rss/search?q=site%3Asinarharian.com.my%20Malaysia&hl=ms-MY&gl=MY&ceid=MY:ms',
            ],
            [
                'name' => 'Teknologi Malaysia',
                'url' => 'https://news.google.com/rss/search?q=teknologi%20Malaysia&hl=ms-MY&gl=MY&ceid=MY:ms',
            ],
        ],
    ],

];
