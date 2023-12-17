<?php



namespace App\Controller;



use \Solenoid\Core\MVC\Controller;

use \Solenoid\HTTP\Server as HTTPServer;
use \Solenoid\HTTP\Cookie;
use \Solenoid\BIN\Endpoint as BINEndpoint;
use \Solenoid\KeyGen\Generator;
use \Solenoid\KeyGen\Token;






class BIN extends Controller
{
    # Returns [void]
    public function get ()
    {
        // Printing the value
        echo parent::$core::$view::build
        (
            'root/BIN/view.blade.php'
        )
        ;
    }

    # Returns [void]
    public function options ()
    {
        // (Setting the cors)
        #HTTPServer::set_cors( [ 'https://remote-app.net' ], [ 'BIN' ], [ 'Action', 'File-Id', 'File-Chunk-Id' ], true );
    }

    # Returns [void]
    public function bin ()
    {
        // (Setting the cors)
        #HTTPServer::set_cors( [ 'https://remote-app.net' ], [], [], true );



        // (Getting the value)
        $transfers_basedir = parent::$core::$basedir . '/storage/transfers';



        // (Starting the endpoint)
        BINEndpoint::create
        (
            [
                'generate_id' => function () use ($transfers_basedir)
                {
                    // Returning the value
                    return
                        Generator::start
                        (
                            function ( $id ) use ($transfers_basedir)
                            {
                                // Returning the value
                                return !is_dir( "$transfers_basedir/$id" );
                            },

                            function ()
                            {
                                // Returning the value
                                return Token::generate( 64 );
                            }
                        )
                    ;
                },

                'validate_id' => function ( $id )
                {
                    // Returning the value
                    return preg_match( '/^[\w]+$/', $id ) === 1;
                },

                'ended' => function ( $transfer )
                {
                    foreach ($transfer->files as $temp_file )
                    {// Processing each entry
                        // (Moving the temp file)
                        $temp_file->move( parent::$core::$basedir . "/storage/transfers.moved/$temp_file->name" );
                    }



                    // (Setting the header)
                    header('Content-Type: application/json');

                    // Printing the value
                    echo $transfer;
                }
            ],
            $transfers_basedir,
            Cookie::create( 'transfer', /*'remote-app.net'*/ '', '', true, true, /* 'None' */ 'Lax' )
        )
            ->start()
        ;
    }
}



?>