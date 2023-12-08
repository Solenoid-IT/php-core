<?php



include_once( __DIR__ . '/lib/autoload.php' );

include_once( __DIR__ . '/config.php' );

include_once( __DIR__ . '/envs.php' );



use \Solenoid\System\Directory;



foreach ([ '/stores', '/models', '/services', '/middlewares/src', '/controllers' ] as $folder_path)
{// Processing each entry
    foreach ( Directory::select( __DIR__ . $folder_path )->list( 0, '/\.php$/' ) as $file_path )
    {// Processing each entry
        // (Including the file)
        include_once( $file_path );
    }
}



?>