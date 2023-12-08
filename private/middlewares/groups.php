<?php



use \App\Middleware\Authentication as AuthenticationMiddleware;



$_CORE['middleware_groups'] =
[
    'authentication' =>
    [
        AuthenticationMiddleware::class
    ]
]
;



?>