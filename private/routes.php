<?php



use \Solenoid\Core\Routing\Destination;



use \App\Controller\FallbackRoute;

use \App\Controller\Dashboard;
use \App\Controller\Login;
use \App\Controller\Logout;
use \App\Controller\Test;
use \App\Controller\Svelte;
use \App\Controller\SSE;
use \App\Controller\Perf;




$_CORE['fallback_route'] = Destination::create( FallbackRoute::class, 'view' );

$_CORE['routes'] =
[
    '/'       =>
    [
        'GET' => Destination::create( Dashboard::class, 'get' )->set_middlewares( ['authentication'] )->set_tags( ['dashboard'] )
    ]
    ,
    '/login'  =>
    [
        'GET' => Destination::create( Login::class, 'get' ),
        'RPC' => Destination::create( Login::class, 'rpc' )
    ]
    ,
    '/logout' =>
    [
        'GET' => Destination::create( Logout::class, 'get' )->set_middlewares( ['authentication'] )
    ]
    ,
    '/test/[ action ]/[ input ]' =>
    [
        'GET' => Destination::create( Test::class, 'get' )->set_middlewares( ['authentication'] )
    ]
    ,
    '/svelte' =>
    [
        'GET' => Destination::create( Svelte::class, 'get' )->set_middlewares( ['authentication'] )
    ]
    ,
    '/sse'  =>
    [
        'GET'     => Destination::create( SSE::class, 'get' )->set_middlewares( ['authentication'] ),
        'OPTIONS' => Destination::create( SSE::class, 'options' )->set_middlewares( ['authentication'] ),
        'SSE'     => Destination::create( SSE::class, 'sse' )->set_middlewares( ['authentication'] )
    ]
    ,
    '/perf' =>
    [
        'GET' => Destination::create( Perf::class, 'get' )
    ]
]
;



?>