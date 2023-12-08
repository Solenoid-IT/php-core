<?php



namespace App\Store;



use \Solenoid\Core\Store;



class Test extends Store
{
    public static $data;



    # Returns [mixed]
    public static function init ()
    {
        if( self::$data ) return self::$data;



        // (Getting the value)
        self::$data =
        [
            'datetime' => date('c')
        ]
        ;



        // Returning the value
        return self::$data;
    }
}



?>