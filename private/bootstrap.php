<?php



include_once( __DIR__ . '/autoload.php' );



use \Solenoid\Core\Core;



// (Initializing a Core)
Core::init( $_CORE );

if ( Core::$context === 'http' )
{// (Core is running under 'http' mode)
    // (Including the files)
    include_once( Core::$basedir . '/routes.php' );

    include_once( Core::$basedir . '/gate.php' );
    include_once( Core::$basedir . '/middlewares/groups.php' );



    // (Setting the routes)
    Core::set_routes( $_CORE['routes'], $_CORE['fallback_route'] );



    // (Setting the gate)
    Core::set_gate( \App\Gate\MainGate::class );

    // (Setting the middlewares)
    Core::set_middlewares( $_CORE['middleware_groups'] );



    // (Resolving the path)
    Core::resolve_path();
}



?>