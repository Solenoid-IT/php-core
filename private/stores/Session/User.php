<?php



namespace App\Store\Session;



use \Solenoid\Core\Store;

use \Solenoid\HTTP\Session;
use \Solenoid\HTTP\SessionContent;
use \Solenoid\HTTP\Cookie;

use \Solenoid\System\File;

use \Solenoid\KeyGen\Generator;



class User extends Store
{
    public static $data;



    # Returns [mixed]
    public static function init ()
    {
        if ( isset( self::$data ) ) return self::$data;



        // (Getting the value)
        $folder_path = parent::$core::$basedir . '/storage/sessions';



        // (Getting the value)
        self::$data =
        [
            'session' => Session::create
            (
                [
                    'validate_id' => function ( $id )
                    {
                        // Returning the value
                        return preg_match( '/^[\w]+$/', $id ) === 1;
                    },

                    'generate_id' => function () use ($folder_path)
                    {
                        // Returning the value
                        return
                            Generator::start
                            (
                                function ($id) use ($folder_path)
                                {
                                    // Returning the value
                                    return !File::select( "$folder_path/$id" )->exists();
                                },
                                function ()
                                {
                                    // Returning the value
                                    return bin2hex( random_bytes( 32 / 2 ) );
                                }
                            )
                        ;
                    },

                    'init' => function ( $id, $duration )
                    {
                        // (Getting the values)
                        $creation   = time();
                        $expiration = $creation + $duration;



                        // Returning the value
                        return SessionContent::create( $creation, $expiration, [] );
                    },

                    'read' => function ( $id, $duration ) use ($folder_path)
                    {
                        // (Getting the value)
                        $file = File::select( "$folder_path/$id" );

                        if ( $file->exists() )
                        {// (File exists)
                            // (Getting the value)
                            $content = $file->read();

                            if ( $content === false )
                            {// (Unable to read the file content)
                                // (Setting the value)
                                $message = "Unable to read the file content";

                                // Throwing an exception
                                throw new \Exception($message);

                                // Returning the value
                                return;
                            }



                            // (Getting the value)
                            $content = json_decode( $content, true );

                            if ( time() - $content['creation'] >= $content['expiration'] )
                            {// (Session is expired)
                                // (Setting the value)
                                $content['data'] = [];
                            }
                        }
                        else
                        {// (File does not exist)
                            // (Getting the values)
                            $creation   = time();
                            $expiration = $creation + $duration;

                            $content = [ 'creation' => $creation, 'expiration' => $expiration, 'data' => [] ];
                        }
        


                        // Returning the value
                        return SessionContent::create( $content['creation'], $content['expiration'], $content['data'] );
                    },

                    'write' => function ( $id, $content ) use ($folder_path)
                    {
                        if ( !File::select( "$folder_path/$id" )->write( json_encode( $content->to_array() ) ) )
                        {// (Unable to write the content to the file)
                            // (Setting the value)
                            $message = "Unable to write the content to the file";

                            // Throwing an exception
                            throw new \Exception($message);

                            // Returning the value
                            return;
                        }
                    },

                    'change_id' => function ( $old, $new ) use ($folder_path)
                    {
                        // (Getting the value)
                        $file = File::select( "$folder_path/$old" );

                        if ( $file->exists() )
                        {// (File exists)
                            if ( !$file->move( "$folder_path/$new" ) )
                            {// (Unable to move the file path)
                                // (Setting the value)
                                $message = "Unable to move the file path";

                                // Throwing an exception
                                throw new \Exception($message);

                                // Returning the value
                                return;
                            }
                        }
                    },

                    'set_expiration' => function ( $duration )
                    {
                        // Returning the value
                        return $duration === null ? null : time() + $duration;
                    },

                    'destroy' => function ( $id ) use ($folder_path)
                    {
                        // (Getting the value)
                        $file = File::select( "$folder_path/$id" );

                        if ( $file->exists() )
                        {// (File exists)
                            if ( !$file->remove() )
                            {// (Unable to remove the file)
                                // (Setting the value)
                                $message = "Unable to remove the file";

                                // Throwing an exception
                                throw new \Exception($message);

                                // Returning the value
                                return;
                            }
                        }
                    },
                ],
                Cookie::create
                (
                    'user',
                    '',
                    '/',
                    true,
                    true
                ),
                3600,
                true
            )
        ]
        ;



        // Returning the value
        return self::$data;
    }
}



?>