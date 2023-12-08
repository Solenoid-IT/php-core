<?php



include_once( __DIR__ . '/../../../../bootstrap.php' );



use \Solenoid\Tasker\Script;
use \Solenoid\Core\Core;
use \Solenoid\System\Process;
use \Solenoid\System\Directory;
use \Solenoid\System\File;



Script::run
(
    function ()
    {
        // ( :: Executing the process synchronously)



        $directory = Directory::select( Core::$basedir . '/storage/process/sync' );
        
        if ( !$directory->exists() ) $directory->empty();



        Process::execute
        (
            function () use ($directory)
            {
                // (Waiting for the time)
                sleep( 10 );

                // (Writing to the file)
                File::select( "$directory/1.txt" )->write( time() );
            }
        )
        ;


        



        Process::execute
        (
            function () use ($directory)
            {
                // (Writing to the file)
                File::select( "$directory/2.txt" )->write( time() );
            }
        )
        ;



        echo "\n\nProcess is terminated !\n\n\n";
    }
)
;



?>