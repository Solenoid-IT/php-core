<?php



namespace App\Controller;



use \Solenoid\Core\MVC\Controller;

use \Solenoid\HTTP\Server;
use \Solenoid\HTTP\Response;

use \App\Store\Session\User as UserSessionStore;




class Logout extends Controller
{
    # Returns [void]
    public function get ()
    {
        // (Initializing the store)
        UserSessionStore::init();

        // (Getting the value)
        $session = UserSessionStore::$data['session'];



        if ( !$session->destroy() )
        {// (Unable to destroy the session)
            // Returning the value
            return
                Server::send( Response::create( 500, [], json_encode( [ 'error' => [ 'message' => [ 'Unable to destroy the session' ] ] ] ) ) )
            ;
        }



        // (Sending the header)
        Server::send_header( 'Location: /login' );
    }
}



?>