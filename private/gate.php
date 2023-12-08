<?php



namespace App\Gate;



use \Solenoid\Core\Gate;

use \Solenoid\Network\IPv4\IPv4;
use \Solenoid\Network\IPv4\Firewall;



class MainGate extends Gate
{
    # Returns [bool]
    public static function run ()
    {
        if ( in_array( 'dashboard', parent::$core::$route_tags ) )
        {// (Route contains this tag)
            // (Creating a Firewall)
            $firewall = Firewall::create
            (
                [],
                [
                    '0.0.0.0/0'
                ]
            )
            ;



            // Returning the value
            return $firewall->check( IPv4::select( parent::$core::$request::$client_ip ) );
        }
    }
}



?>