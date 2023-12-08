<?php



include_once( __DIR__ . '/../../../../bootstrap.php' );



use \Solenoid\Tasker\Script;
use \Solenoid\Core\Core;
use \Solenoid\System\Directory;
use \Solenoid\System\File;
use \Solenoid\System\Parallelism;



Script::run
(
    function ()
    {
        // (Getting the value)
        $directory = Directory::select( Core::$basedir . '/storage/process/parallel' );

        if ( !$directory->exists() ) $directory->make();



        // (Emptying the directory)
        $directory->empty();



        // Returning the value
        return
            Parallelism::create
            (
                [
                    function () use ($directory)
                    {
                        // (Waiting for the time)
                        sleep( 10 );

                        // (Writing to the file)
                        File::select( "$directory/1.txt" )->write( time() );
                    },

                    function () use ($directory)
                    {
                        // (Writing to the file)
                        File::select( "$directory/2.txt" )->write( time() );
                    }
                ]
            )
                ->run()
        ;
    }
)
;



?>