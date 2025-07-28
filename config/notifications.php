<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Notification Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the default notification channel that gets used
    | while using this notification library. This channel is used when
    | another is not explicitly specified when sending a notification.
    |
    */

    'default' => env('BROADCAST_DRIVER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | Notification Channels
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the notification "channels" for your app as
    | well as their respective configuration settings. A default setup
    | has been added for each channel as an example of the required options.
    |
    */

    'channels' => [

        'mail' => [
            'transport' => env('MAIL_MAILER', 'smtp'),
        ],

        'database' => [
            'connection' => env('DB_CONNECTION', 'mysql'),
            'table' => 'notifications',
        ],

        'broadcast' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ],
        ],

        'slack' => [
            'webhook_url' => env('SLACK_WEBHOOK_URL'),
        ],

        'nexmo' => [
            'key' => env('NEXMO_KEY'),
            'secret' => env('NEXMO_SECRET'),
            'sms_from' => env('NEXMO_SMS_FROM'),
        ],

    ],

];
return [
    'default' => 'database',

    'channels' => [

        'database' => [
            'connection' => env('DB_CONNECTION', 'mysql'),
            'table' => 'notifications',
        ],

    ],
];
