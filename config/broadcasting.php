<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    | Supported: "pusher", "ably", "redis", "log", "null"
    |
    */

    'default' => env('BROADCAST_DRIVER', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that will be used
    | to broadcast events to other systems or over websockets. Samples of
    | each available type of connection are provided inside this array.
    |
    */

    'connections' => [
//	'pusher' => [
//            'driver' => 'pusher',
//            'key' => env('VITE_PUSHER_APP_KEY'),
//            'secret' =>env('VITE_PUSHER_APP_SECRET'),
//            'app_id' => env('VITE_PUSHER_APP_ID'),
//            'options' => [
//                'cluster' => env('PUSHER_APP_CLUSTER'),
//                'host' =>'localhost',
//                'port' => '6001',
//                'scheme' => 'http',
//                'encrypted' => true,
//                'verify_peer' => false,
//                'useTLS' => true,
//                'curl_options' => [
 //                       CURLOPT_SSL_VERIFYHOST => 0,
   //                     CURLOPT_SSL_VERIFYPEER => 0,
     //           ],
      //      ],
       // ],

	'pusher' => [
 		'driver' => 'pusher',
                'key' => env('VITE_PUSHER_APP_KEY'),
                'secret' =>env('VITE_PUSHER_APP_SECRET'),
                'app_id' => env('VITE_PUSHER_APP_ID'),
    		'options' => [
        		'cluster' => 'ap2', // Not necessary for local WebSockets, consider removing
        		'useTLS' => true, // Set to true if using SSL/TLS
        		'encrypted' => true, // Deprecated in favor of useTLS, but can be set for older versions
        		'host' => 'ws.armaitimex.com', // Your WebSocket server
			'verify_peer' => false,
        		'port' => 6001, // Your WebSocket server port
        		'scheme' => 'http', // Set to https if using SSL/TLS
    		],
	],

        'ably' => [
            'driver' => 'ably',
            'key' => env('ABLY_KEY'),
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
