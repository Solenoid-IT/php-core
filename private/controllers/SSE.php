<?php



namespace App\Controller;



use \Solenoid\Core\MVC\Controller;

use \Solenoid\HTTP\Server as HTTPServer;
use \Solenoid\SSE\Event;
use \Solenoid\SSE\Server as SSEServer;






class SSE extends Controller
{

    # Returns [void]
    public function get ()
    {
        // (Printing the value)
        echo parent::$core::$view::build
        (
            'root/SSE/view.blade.php'
        )
        ;
    }

    # Returns [void]
    public function options ()
    {
        // (Setting the cors)
        HTTPServer::set_cors();
    }

    # Returns [void]
    public function sse ()
    {
        // (Starting the server)
        SSEServer::create( 30 )->start
        (
            function ()
            {
                // (Waiting for the time)
                sleep( 1 );



                // Returning the value
                return
                    Event::create( 'timeupdate', json_encode( [ 'datetime' => date('c') ] ) )
                ;
            }
        )
        ;
    }
}



?>