<?php



use \Solenoid\Core\Core;
use \Solenoid\Core\Env;



$_CORE['envs'] =
[
    'dev'  => Env::create
    (
        Env::TYPE_DEV,
        [
            '127.0.0.1',
            'localhost',
            'dev.app.com',
            Core::get_host()# :: (Replace this one with your apache virtual-host real domain)
        ]
    ),

    'prod' => Env::create
    (
        Env::TYPE_PROD,
        [
            'app.com'
        ]
    )
]
;



?>