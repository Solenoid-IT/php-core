<?php



include_once( __DIR__ . '/../../../../bootstrap.php' );



use \Solenoid\Tasker\Script;
use \Solenoid\Core\Core;
use \Solenoid\System\ChildProcess;
use \Solenoid\Log\Logger;



Script::run
(
    function ()
    {
        // (Reading from the STDIN)
        $input = ChildProcess::read();

        // (Getting the value)
        $start_timestamp = json_decode( $input, true )['start_timestamp'];



        // (Waiting for the seconds)
        sleep( 10 );



        // (Writing to the STDOUT)
        ChildProcess::write( json_encode( [ 'response_timestamp' => time() ] ) );



        // (Getting the value)
        $start_datetime = date( 'c', $start_timestamp );



        // (Creating a Logger)
        $logger = Logger::create( Core::$basedir . '/storage/process/child/calls.log' );

        // (Pushing the message)
        $logger->push( "Child process spawned at `$start_datetime` has been terminated !" );
    }
)
;



?>