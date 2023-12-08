<?php



include_once( __DIR__ . '/../../../../bootstrap.php' );



use \Solenoid\Tasker\Script;
use \Solenoid\Core\Core;
use \Solenoid\System\BackgroundProcess;
use \Solenoid\Log\Logger;



Script::run
(
    function ()
    {
        // (Getting the value)
        $input = BackgroundProcess::read();

        // (Getting the value)
        $start_timestamp = json_decode( $input, true )['start_timestamp'];



        // (Waiting for the seconds)
        sleep( 10 );



        // (Getting the value)
        $start_datetime = date( 'c', $start_timestamp );



        // (Creating a Logger)
        $logger = Logger::create( Core::$basedir . '/storage/process/background/calls.log' );

        // (Pushing the message)
        $logger->push( "Background process spawned at `$start_datetime` has been terminated !" );
    }
)
;



?>