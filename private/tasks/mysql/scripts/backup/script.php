<?php



include_once( __DIR__ . '/../../../../bootstrap.php' );



use \Solenoid\Tasker\Script;
use \Solenoid\Tasker\Config;

use \Solenoid\Core\Core;
use \Solenoid\System\Directory;
use \Solenoid\System\File;
use \Solenoid\MySQL\CLI as MySQLCLI;




Script::run
(
    function ()
    {
        // (Getting the value)
        $config = Config::read();



        // (Getting the value)
        $folder_path = Core::$basedir . '/storage/mysql-exports';

        if ( !is_dir( $folder_path ) )
        {// (Directory not found)
            // (Making the directory)
            mkdir( $folder_path );
        }



        // (Setting the directory)
        chdir( $folder_path );



        // (Getting the value)
        $files = Directory::select( '.' )->resolve()->list( 1 );

        foreach ($files as $file)
        {// Processing each entry
            // (Getting the value)
            $file = File::select( $file );

            if ( time() - $file->get_metadata( 'CREATION_TIME' ) > 15 * 86400 )
            {// (File has been created more than 15 days ago)
                // (Removing the file)
                $file->remove();
            }
        }



        // Returning the value
        return
            MySQLCLI::export
            (
                'localhost',
                3306,

                'core_demo',
                'p1a2s3s4w5o6r7d8',

                $config['databases']
            )
                ?
            "\n\nDatabases have been exported !\n\n\n"
                :
            "\n\nUnable to export the databases !\n\n\n"
        ;
    }
)
;



?>