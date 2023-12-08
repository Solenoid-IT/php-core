<?php



namespace App\Store;



use \Solenoid\Core\Store;

use \Solenoid\HTTP\Cookie;
use \Solenoid\MySQL\DateTime as MySQLDateTime;
use \Solenoid\DateTime\DateTime;



class Localizer extends Store
{
    public static $data;



    # Returns [mixed]
    public static function init ()
    {
        if ( isset( self::$data ) ) return self::$data;



        // (Getting the value)
        self::$data =
        [
            'localize_datetime' => function (string $datetime)
            {
                // (Getting the value)
                $timezone = Cookie::fetch_value( 'timezone' );



                // Returning the value
                return
                    $timezone
                        ?
                    DateTime::create( MySQLDateTime::create( $datetime )->to_iso() )->convert( $timezone, 'Y-m-d H:i:s' )
                        :
                    $datetime . ' UTC'
                ;
            }
        ]
        ;



        // Returning the value
        return self::$data;
    }
}



?>