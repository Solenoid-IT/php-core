<?php



namespace App\Middleware;



use \Solenoid\Core\Middleware;
use \Solenoid\HTTP\Server;
use \Solenoid\HTTP\Cookie;

use \App\Store\Session\User as UserSessionStore;



class Authentication extends Middleware
{
    # Returns [bool] | Throws [Exception]
    public static function run ()
    {
        // (Initializing the store)
        UserSessionStore::init();

        // (Getting the value)
        $session = UserSessionStore::$data['session'];



        if ( !$session->start() )
        {// (Unable to start the session)
            // (Setting the value)
            $message = "Unable to start the session";

            // Throwing an exception
            throw new \Exception($message);

            // Returning the value
            return false;
        }

        if ( parent::$core::$request::$method !== 'BIN' )
        {// (There is not a transfer in progress)
            if ( !$session->regenerate_id() )
            {// (Unable to regenerate the session id)
                // (Setting the value)
                $message = "Unable to regenerate the session id";

                // Throwing an exception
                throw new \Exception($message);

                // Returning the value
                return false;
            }
        }



        if ( $session->data['id'] )
        {// Value found
            // (Getting the value)
            $route = Cookie::fetch_value( 'route' );

            if ( $route )
            {// Value found
                // (Deleting the cookie)
                Cookie::delete( 'route' );

                // (Sending the header)
                Server::send_header( "Location: $route" );



                // Returning the value
                return false;
            }
        }
        else
        {// Value not found
            if ( !$session->destroy() )
            {// (Unable to destroy the session)
                // (Setting the value)
                $message = "Unable to destroy the session";

                // Throwing an exception
                throw new \Exception($message);

                // Returning the value
                return false;
            }



            // (Getting the value)
            $route = parent::$core::$request::get_route( true );

            if ( $route !== '/logout' )
            {// Match OK
                // (Setting the cookie)
                Cookie::create( 'route', '', '/', true, true )->set( $route );
            }



            // (Setting the http status code)
            Server::set_status_code( 401 );

            // (Sending the header)
            Server::send_header( 'Location: /login' );



            // Returning the value
            return false;
        }
    }
}



?>