<?php



include_once( __DIR__ . '/../../../../bootstrap.php' );



use \Solenoid\Tasker\Script;
use \Solenoid\Core\Core;
use \Solenoid\System\Directory;
use \Solenoid\System\File;
use \Solenoid\System\Resource;



Script::run
(
    function ()
    {
        // (Getting the value)
        $files = Directory::select( Core::$basedir . '/storage/sessions' )->list( 1 );

        foreach ($files as $file)
        {// Processing each entry
            if ( !Resource::select( $file )->is_file() ) continue;



            // (Creating a File)
            $file = File::select( $file );



            // (Getting the value)
            $content = $file->read();

            if ( $content === false )
            {// (Unable to read the file content)
                // (Setting the value)
                $message = "Unable to read the file content";

                // Throwing an exception
                throw new \Exception($message);

                // Returning the value
                return false;
            }



            // (Getting the value)
            $expiration = json_decode( $content, true )['expiration'];

            if ( time() >= $expiration )
            {// (Session is expired)
                if ( !$file->remove() )
                {// (Unable to remove the file)
                    // (Setting the value)
                    $message = "Unable to remove the file";

                    // Throwing an exception
                    throw new \Exception($message);

                    // Returning the value
                    return false;
                }



                // (Getting the value)
                $session_id = basename( $file );

                // Printing the value
                echo "\n\nSession $session_id is expired at " . date( 'c', $expiration ) . " -> REMOVED\n\n";
            }
        }



        // Printing the value
        echo "\n";



        // Returning the value
        return true;
    }
)
;



?>