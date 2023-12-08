<?php



namespace App\Controller;



use \Solenoid\Core\MVC\Controller;

use \Solenoid\RPC\Server;
use \Solenoid\RPC\Request;
use \Solenoid\RPC\Response;

use \App\Model\User as UserModel;
use \App\Model\Visitor as VisitorModel;

use \App\Store\Session\User as UserSessionStore;






class Login extends Controller
{
    # Returns [void]
    public function get ()
    {
        // (Printing the value)
        echo parent::$core::$view::build
        (
            'root/Login/view.blade.php'
        )
        ;
    }

    # Returns [void]
    public function rpc ()
    {
        // (Reading the request)
        $request = Request::read();

        if ( $request::$valid )
        {// (Request is valid
            switch ( $request::$subject )
            {
                case 'user':
                    switch ( $request::$verb )
                    {
                        case 'start_session':
                            // (Getting the value)
                            $user = UserModel::find( 'username', $request::$input['username'] );

                            if ( $user === false )
                            {// (User not found)
                                // Returning the value
                                return
                                    Server::send( Response::create( 501, [], [ 'error' => [ 'message' => 'Login failed' ] ] ) )
                                ;
                            }

                            if ( !password_verify( $request::$input['password'], $user['password'] ) )
                            {// (Password is not the same)
                                // Returning the value
                                return
                                    Server::send( Response::create( 501, [], [ 'error' => [ 'message' => 'Login failed' ] ] ) )
                                ;
                            }



                            // (Initializing the store)
                            UserSessionStore::init();

                            // (Getting the value)
                            $session = UserSessionStore::$data['session'];



                            if ( !$session->start() )
                            {// (Unable to start the session)
                                // Returning the value
                                return
                                    Server::send( Response::create( 500, [], [ 'error' => [ 'message' => [ 'Unable to start the session' ] ] ] ) )
                                ;
                            }

                            if ( !$session->regenerate_id() )
                            {// (Unable to regenerate the session id)
                                // Returning the value
                                return
                                    Server::send( Response::create( 500, [], [ 'error' => [ 'message' => [ 'Unable to regenerate the session id' ] ] ] ) )
                                ;
                            }

                            if ( !$session->set_duration() )
                            {// (Unable to set the session duration)
                                // Returning the value
                                return
                                    Server::send( Response::create( 500, [], [ 'error' => [ 'message' => [ 'Unable to set the session duration' ] ] ] ) )
                                ;
                            }



                            // (Getting the value)
                            $session->data['id'] = $user['id'];



                            // (Getting the values)
                            $client_ip = parent::$core::$request::$client_ip;
                            $b64e_ua   = base64_encode( parent::$core::$request::$headers['User-Agent'] );


                            $ip = json_decode( file_get_contents( "https://api.solenoid.it/ip-info/1/$client_ip"  ), true );
                            $ua = json_decode( file_get_contents( "https://api.solenoid.it/ua-info/1/$b64e_ua" ), true );



                            // (Getting the value)
                            $kv_data =
                            [
                                'ip.address'      => $ip['ip']['address'],
                                'ip.country.code' => $ip['geolocation']['country']['code'],
                                'ip.country.name' => $ip['geolocation']['country']['name'],
                                'ip.isp'          => $ip['connection']['isp'],

                                'user_agent'      => $ua['user_agent'],

                                'browser'         => $ua['browser']['summary'],
                                'os'              => $ua['os']['summary'],
                                'hw'              => $ua['hw']['summary'],

                                'datetime.insert' => \Solenoid\MySQL\DateTime::fetch()
                            ]
                            ;

                            if ( !VisitorModel::register( $kv_data ) )
                            {// (Unable to register the visitor)
                                // Returning the value
                                return
                                    Server::send( Response::create( 500, [], [ 'error' => [ 'message' => 'Unable to register the visitor' ] ] ) )
                                ;
                            }



                            // Returning the value
                            return
                                Server::send( Response::create( 200 ) )
                            ;
                        break;
                    }
                break;
            }
        }
    }
}



?>