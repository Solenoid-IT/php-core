<?php



$_CORE =
[
    'basedir'         => __DIR__,

    'app_version'     => '0.0.0',

    'logs'            =>
    [
        'http'        =>
        [
            'error'   => __DIR__ . '/logs/http/error.log',
            'call'    => __DIR__ . '/logs/http/call.log',
        ],

        'cli'         =>
        [
            'error'   => __DIR__ . '/logs/cli/error.log',
            'call'    => __DIR__ . '/logs/cli/call.log',
        ]
    ],

    'storage'         => __DIR__ . '/storage',

    'blade'           =>
    [
        'views'       => __DIR__ . '/views',
        'cache'       => __DIR__ . '/views/_cache'
    ],

    'timezone'        => 'UTC'
]
;



?>