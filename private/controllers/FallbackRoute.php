<?php



namespace App\Controller;



use \Solenoid\Core\MVC\Controller;



class FallbackRoute extends Controller
{
    # Returns [void]
    public function view ()
    {
        // (Printing the value)
        echo parent::$core::$view::build
        (
            'root/FallbackRoute/view.blade.php',
            [
                'title' => 'ROUTE NOT FOUND'
            ]
        )
        ;
    }
}



?>