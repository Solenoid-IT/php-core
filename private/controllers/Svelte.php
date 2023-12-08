<?php



namespace App\Controller;



use \Solenoid\Core\MVC\Controller;

use \App\Store\Session\User as UserSessionStore;
use \App\Model\User as UserModel;






class Svelte extends Controller
{
    # Returns [void]
    public function get ()
    {
        // (Initializing the store)
        UserSessionStore::init();

        // (Getting the value)
        $session =  UserSessionStore::$data['session'];



        // (Getting the value)
        $user = UserModel::find( 'id', $session->data['id'] );



        // (Printing the value)
        echo parent::$core::$view::build
        (
            parent::$core::$view::resolve_svelte_path( 'test.blade.php' ),

            [
                'message' => 'This is a Svelte page test'
            ],

            [
                'appVersion' => parent::$core::$app_version,
                'user'       => $user
            ]
        )
        ;
    }
}



?>