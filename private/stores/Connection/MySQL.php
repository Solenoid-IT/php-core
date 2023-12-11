<?php



namespace App\Store\Connection;



use \Solenoid\Core\Store;
use \Solenoid\MySQL\Connection;



class MySQL extends Store
{
    public static array $data;



    # Returns [mixed]
    public static function init ()
    {
        if ( isset( self::$data ) ) return self::$data;



        // (Getting the value)
        self::$data =
        [
            'demo' => Connection::create( 'localhost', null, 'core_demo', 'p1a2s3s4w5o6r7d8' )
        ]
        ;



        // Returning the value
        return self::$data;
    }
}



?>