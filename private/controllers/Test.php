<?php



namespace App\Controller;



use \Solenoid\Core\MVC\Controller;

use \Solenoid\Network\IPv4\Firewall;
use \Solenoid\Debug\Debugger;

use \Solenoid\CDN\Router;
use \Solenoid\CDN\Server as CDNServer;

use \Solenoid\System\Stream;
use \Solenoid\System\File;
use \Solenoid\System\Byte;
use \Solenoid\HTTP\Server as HTTPServer;
use \Solenoid\HTTP\Retry as HTTPRetry;

use \Solenoid\Collection\Collection;
use \Solenoid\Collection\SortKey;

use \Solenoid\CSV\Config;
use \Solenoid\CSV\Reader;
use \Solenoid\CSV\Writer;
use \Solenoid\System\EOL;

use \Solenoid\DateTime\DateTime;

use \Solenoid\HTTP\Cookie;
use \Solenoid\HTTP\Request as HTTPRequest;
use \Solenoid\HTTP\URL;

use \Solenoid\Network\Host;

use \Solenoid\MySQL\QueryRunner;
use \Solenoid\MySQL\DateTime as MySQLDateTime;

use \Solenoid\System\BackgroundProcess;
use \Solenoid\System\ChildProcess;
use \Solenoid\System\Queue;
use \Solenoid\System\Directory;

use \Solenoid\XML\Document as XMLDocument;

use \Solenoid\ZIP\Archive as ZIPArchive;

use \App\Store\Connection\MySQL as MySQLConnectionStore;






class Test extends Controller
{
    # Returns [void]
    public function get ()
    {
        switch ( parent::$core::$path_args['action'] )
        {
            case 'Firewall::check':
                // (Creating a Firewall)
                $firewall = Firewall::create
                (
                    [],
                    [
                        '1.2.3.4/24'
                    ]
                )
                ;

                // (Getting the value)
                $client_ip = $_SERVER['REMOTE_ADDR'];



                // Returning the value
                return
                    [
                        'client_ip' => $client_ip,
                        'result'    => $firewall->check( $client_ip )
                    ]
                ;
            break;

            case 'Router::resolve':
                // (Resolving the path)
                Router::create
                (
                    Directory::select( parent::$core::$basedir . '/../web/cdn' )->resolve(),
                    [
                        '/\.xml$/' => function ($resource)
                        {
                            if ( $resource->is_file() )
                            {// (Resource is a file)
                                // (Getting the value)
                                $file = File::select( $resource );



                                // (Setting the headers)
                                HTTPServer::send_headers
                                (
                                    [
                                        'Content-Type: '                              . $file->get_type(),
                                        'Content-Length: '                            . $file->get_size(),
                                        'Content-Disposition: attachment; filename="' . basename( $file ) . '"'
                                    ]
                                )
                                ;

                                // (Sending the content)
                                CDNServer::send( Stream::open( $file ), Byte::convert( 128, 'K' ) );



                                // Returning the value
                                return false;
                            }
                        },

                        '/./'      => function ($resource)
                        {
                            // (Doing nothing)
                        }
                    ]
                )
                    ->resolve( parent::$core::$request::parse_query()['path'] )
                ;
            break;



            case 'Collection::group':
                // Returning the value
                return
                    Collection::create
                    (
                        [
                            [
                                'name'       => 'John Smith',
                                'position'   => 'CTO',
                                'department' => 'administration',
                                'seniority'  => 10
                            ],

                            [
                                'name'       => 'Sandra Houston',
                                'position'   => 'Full Stack Web Developer',
                                'department' => 'development',
                                'seniority'  => 7
                            ],

                            [
                                'name'       => 'Erik Johnson',
                                'position'   => 'Full Stack Web Developer',
                                'department' => 'development',
                                'seniority'  => 4
                            ],

                            [
                                'name'       => 'Mark Bullock',
                                'position'   => 'Graphic Designer',
                                'department' => 'marketing',
                                'seniority'  => 4
                            ],

                            [
                                'name'       => 'Matthew Gates',
                                'position'   => 'Network Engineer',
                                'department' => 'datacenter',
                                'seniority'  => 7
                            ],

                            [
                                'name'       => 'Monica Lavigne',
                                'position'   => 'Head Hunter',
                                'department' => 'hr',
                                'seniority'  => 5
                            ],

                            [
                                'name'       => 'Anthony Stewart',
                                'position'   => 'Commercial Consultant',
                                'department' => 'sales',
                                'seniority'  => 2
                            ]
                        ]
                    )
                        ->filter( function ($record) { return $record['seniority'] > 2; } )
                        ->group( [ 'seniority', 'department' ] )
                ;
            break;

            case 'Collection::sort':
                // Returning the value
                return
                    Collection::create
                    (
                        [
                            [
                                'name'       => 'John Smith',
                                'position'   => 'CTO',
                                'department' => 'administration',
                                'seniority'  => 10
                            ],

                            [
                                'name'       => 'Sandra Houston',
                                'position'   => 'Full Stack Web Developer',
                                'department' => 'development',
                                'seniority'  => 7
                            ],

                            [
                                'name'       => 'Erik Johnson',
                                'position'   => 'Full Stack Web Developer',
                                'department' => 'development',
                                'seniority'  => 4
                            ],

                            [
                                'name'       => 'Mark Bullock',
                                'position'   => 'Graphic Designer',
                                'department' => 'marketing',
                                'seniority'  => 4
                            ],

                            [
                                'name'       => 'Matthew Gates',
                                'position'   => 'Network Engineer',
                                'department' => 'datacenter',
                                'seniority'  => 7
                            ],

                            [
                                'name'       => 'Monica Lavigne',
                                'position'   => 'Head Hunter',
                                'department' => 'hr',
                                'seniority'  => 5
                            ],

                            [
                                'name'       => 'Anthony Stewart',
                                'position'   => 'Commercial Consultant',
                                'department' => 'sales',
                                'seniority'  => 2
                            ]
                        ]
                    )
                        ->sort( [ SortKey::create( 'seniority', SortKey::DIR_DESC ) ] )
                        ->to_array()
                ;
            break;



            case 'CSV::read':
                // (Getting the values)
                $file_path = parent::$core::$basedir . '/../web/cdn/3/cities.csv';
                $reader    = Reader::create( $file_path, Config::create( EOL::detect( File::select( $file_path )->read() ) ) );
                $schema    = $reader->fetch_schema();



                // (Opening the reader)
                $reader->open();



                // (Fetching the record)
                $reader->fetch_record();



                // (Setting the value)
                $records = [];

                while ( $record = $reader->fetch_record( $schema ) )
                {// Processing each entry
                    foreach ($record as $k => $v)
                    {// Processing each entry
                        $record[ $k ] = trim( $v );
                    }



                    // (Appending the value)
                    $records[] = $record;
                }



                // (Closing the reader)
                $reader->close();



                // Returning the value
                return $records;
            break;

            case 'CSV::read_once':
                // (Getting the values)
                $file_path = parent::$core::$basedir . '/../web/cdn/3/cities.csv';
                $reader    = Reader::create( $file_path, Config::create( EOL::detect( File::select( $file_path )->read() ) ) );



                // Returning the value
                return
                    $reader->fetch_records
                    (
                        $reader->fetch_schema(),
                        function ($record)
                        {
                            foreach ($record as $k => $v)
                            {// Processing each entry
                                $record[ $k ] = trim( $v );
                            }
                            


                            // Returning the value
                            return $record;
                        }
                    )
                ;
            break;

            case 'CSV::write':
                // (Setting the value)
                $records =
                [
                    [
                        'name'       => 'John Smith',
                        'position'   => 'CTO',
                        'department' => 'administration',
                        'seniority'  => 10
                    ],

                    [
                        'name'       => 'Sandra Houston',
                        'position'   => 'Full Stack Web Developer',
                        'department' => 'development',
                        'seniority'  => 7
                    ],

                    [
                        'name'       => 'Erik Johnson',
                        'position'   => 'Full Stack Web Developer',
                        'department' => 'development',
                        'seniority'  => 4
                    ],

                    [
                        'name'       => 'Mark Bullock',
                        'position'   => 'Graphic Designer',
                        'department' => 'marketing',
                        'seniority'  => 4
                    ],

                    [
                        'name'       => 'Matthew Gates',
                        'position'   => 'Network Engineer',
                        'department' => 'datacenter',
                        'seniority'  => 7
                    ],

                    [
                        'name'       => 'Monica Lavigne',
                        'position'   => 'Head Hunter',
                        'department' => 'hr',
                        'seniority'  => 5
                    ],

                    [
                        'name'       => 'Anthony Stewart',
                        'position'   => 'Commercial Consultant',
                        'department' => 'sales',
                        'seniority'  => 2
                    ]
                ]
                ;

                // (Getting the values)
                $file_path = parent::$core::$basedir . '/../web/cdn/3/build.csv';
                $writer    = Writer::create( $file_path, Config::create() );



                // (Setting the schema)
                $writer->set_schema( array_keys( $records[0] ) );

                foreach ($records as $record)
                {// Processing each entry
                    // (Pushing the record)
                    $writer->push_record( $record );
                }
            break;



            case 'DateTime::convert':
                // Returning the value
                return DateTime::create( '2023-11-19 20:34:36' )->convert('UTC', 'Y-m-d H:i:s');
            break;



            case 'Cookie::set':
                // Returning the value
                return Cookie::create( 'TEST', '', '/', true, true )->set( 'VALUE -> {[(%&$€ ' . date('c') . ' )]}' );
            break;

            case 'Cookie::fetch_value':
                // Returning the value
                return Cookie::fetch_value( 'TEST' );
            break;

            case 'Cookie::delete':
                // Returning the value
                return Cookie::delete( 'TEST', '', '/' );
            break;



            case 'Request::read':
                // Returning the value
                return HTTPRequest::read()->to_array();
            break;

            case 'Request::send':
                // Returning the value
                return
                    HTTPRequest::send
                    (
                        'https://api.solenoid.it/ua-info/1',
                        'GET',
                        [
                            'User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_1_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Mobile/15E148 Safari/604.1'
                        ],
                        '',

                        'json',

                        false,

                        [],

                        HTTPRetry::create()
                    )
                        ->body
                ;
            break;

            case 'URL::parse':
                // Returning the value
                return URL::parse('https://user:pass@domain.net:8081/p/a/t/h?q=u&e=r#y');
            break;



            case 'MySQL::insert':
                // (Getting the value)
                $mysql_connection = MySQLConnectionStore::init()['demo'];



                // (Setting the values)
                $kv_data =
                [
                    'id'      => 1,
                    
                    'name'    => 'John',
                    'surname' => 'Smith',

                    'admin'   => false,

                    'score'   => 2.59
                ]
                ;

                $raw_kv_data =
                [
                    'datetime.insert' => 'CURRENT_TIMESTAMP'
                ]
                ;

                // (Creating a QueryRunner)
                QueryRunner::create( $mysql_connection, 'core_demo', 'test', false )->capture( $query )->insert( $kv_data, $raw_kv_data, true );



                // Printing the value
                Debugger::print_html( $query );
            break;

            case 'MySQL::multi_insert':
                // (Getting the value)
                $mysql_connection = MySQLConnectionStore::init()['demo'];



                // (Getting the value)
                $insert_datetime = MySQLDateTime::fetch();



                // (Setting the value)
                $kv_data_list =
                [
                    [
                        'id'              => 1,
                        
                        'name'            => 'John',
                        'surname'         => 'Smith',
    
                        'admin'           => false,
    
                        'score'           => 2.59,

                        'datetime.insert' => $insert_datetime
                    ],

                    [
                        'id'              => 2,
                        
                        'name'            => 'Sam',
                        'surname'         => 'Hawthorne',
    
                        'admin'           => true,
    
                        'score'           => 9.81,

                        'datetime.insert' => $insert_datetime
                    ]
                ]
                ;

                // (Creating a QueryRunner)
                QueryRunner::create( $mysql_connection, 'core_demo', 'test', false )->capture( $query )->multi_insert( $kv_data_list, true );



                // Printing the value
                Debugger::print_html( $query );
            break;

            case 'MySQL::update':
                // (Getting the value)
                $mysql_connection = MySQLConnectionStore::init()['demo'];



                // (Setting the values)
                $kv_data =
                [
                    'name' => 'Jonathan'
                ]
                ;

                $raw_kv_data =
                [
                    'datetime.update' => 'CURRENT_TIMESTAMP'
                ]
                ;

                // (Creating a QueryRunner)
                QueryRunner::create( $mysql_connection, 'core_demo', 'test', false )->capture( $query )->where( 'id', '=', 1 )->update( $kv_data, $raw_kv_data );



                // Printing the value
                Debugger::print_html( $query );
            break;

            case 'MySQL::set':
                // (Getting the value)
                $mysql_connection = MySQLConnectionStore::init()['demo'];



                // (Setting the values)
                $kv_data =
                [
                    'name'    => 'App',
                    'surname' => 'Y'
                ]
                ;

                $raw_kv_data =
                [
                    'photo'           => 'NULL',
                    'datetime.insert' => 'CURRENT_TIMESTAMP'
                ]
                ;

                // (Creating a QueryRunner)
                QueryRunner::create( $mysql_connection, 'core_demo', 'user', false )->capture( $query )->set( $kv_data, $raw_kv_data, [ 'name', 'photo' ], true );



                // Printing the value
                Debugger::print_html( $query );
            break;

            case 'MySQL::delete':
                // (Getting the value)
                $mysql_connection = MySQLConnectionStore::init()['demo'];



                // (Creating a QueryRunner)
                QueryRunner::create( $mysql_connection, 'core_demo', 'test', false )->capture( $query )->where( 'admin', 'IS', false )->delete();



                // Printing the value
                Debugger::print_html( $query );
            break;

            case 'MySQL::truncate':
                // (Getting the value)
                $mysql_connection = MySQLConnectionStore::init()['demo'];



                // (Creating a QueryRunner)
                QueryRunner::create( $mysql_connection, 'core_demo', 'test', false )->capture( $query )->truncate( true );



                // Printing the value
                Debugger::print_html( $query );
            break;

            case 'MySQL::select':
                // (Getting the value)
                $mysql_connection = MySQLConnectionStore::init()['demo'];



                // (Creating a QueryRunner)
                QueryRunner::create( $mysql_connection, 'core_demo', 'test', false )->capture( $query )->where( 'admin', 'IS', false )->w_and()->where( 'score', '>', 2 )->select( [ 'name', 'surname' ], true, false );



                // Printing the value
                Debugger::print_html( $query );
            break;

            case 'MySQL::find':
                // (Getting the value)
                $mysql_connection = MySQLConnectionStore::init()['demo'];



                // (Setting the values)
                $kv_data =
                [
                    'name'   => 'Jonathan',
                    'admin' => true
                ]
                ;

                $raw_kv_data =
                [
                    'datetime.update' => 'CURRENT_TIMESTAMP'
                ]
                ;

                $columns =
                [
                    'name',
                    'surname',
                    'score'
                ]
                ;

                // (Creating a QueryRunner)
                QueryRunner::create( $mysql_connection, 'core_demo', 'test', false )->capture( $query )->find( $kv_data, $raw_kv_data, true, $columns );



                // Printing the value
                Debugger::print_html( $query );
            break;

            case 'MySQL::raw':
                // (Getting the value)
                $mysql_connection = MySQLConnectionStore::init()['demo'];



                // (Setting the values)
                $q =
                <<<EOQ
                SELECT
                    *
                FROM
                    `db`.`tbl` T
                WHERE
                    (
                        T.`name` <> {{ name }}
                            AND
                        T.`surname` = {{ surname }}
                    )
                        OR
                    (
                        T.`name` <> {{ other_name }}
                    )
                        OR
                    T.`score` {! expression !}
                ;
                EOQ
                ;

                $kv_data =
                [
                    'name'       => 'Jonathan',
                    'surname'    => 'Smith',

                    'other_name' => "Charlie O'Brien",

                    'expression' => 'BETWEEN 80 AND 100'
                ]
                ;

                // (Creating a QueryRunner)
                QueryRunner::create( $mysql_connection, 'core_demo', 'test', false )->capture( $query )->raw( $q, $kv_data );



                // Printing the value
                Debugger::print_html( $query );
            break;



            case 'Host::ping':
                // Returning the value
                return Host::select( 'google.com' )->ping();
            break;

            case 'Host::resolve':
                // Returning the value
                return
                    [
                        'youtube.ca' => Host::select( 'youtube.ca' )->resolve( '8.8.8.8' ),
                        'winbox'     => Host::select( 'winbox' )->resolve( '1.1.1.1' )
                    ]
                ;
            break;



            case 'BackgroundProcess::spawn':
                // Returning the value
                return
                    BackgroundProcess::create
                    ( 
                        parent::$core::$basedir,
                        'php x task process run background',
                        json_encode( [ 'start_timestamp' => time() ] )
                    )
                        ->spawn()
                        ->get_pid()
                ;
            break;

            case 'ChildProcess::spawn':
                // (Creating a child process)
                $cp = ChildProcess::create( parent::$core::$basedir, 'php x task process run child' );

                // (Spawning the process)
                $cp->spawn();



                // (Writing to the stream)
                $cp->stdin->write( json_encode( [ 'start_timestamp' => time() ] ) );

                // (Closing the stream)
                $cp->stdin->close();



                // (Reading from the stream)
                $cp_output = $cp->stdout->read();

                // (Closing the stream)
                $cp->stdout->close();



                // (Waiting for the process termination -> You can omit this one for background processes)
                $exitcode = $cp->wait();



                // Returning the value
                return
                    [
                        'exitcode' => $exitcode,
                        'output'   => json_decode( $cp_output, true )
                    ]
                ;
            break;

            case 'Byte::convert':
                // Returning the value
                return Byte::convert( 4, 'K' );
            break;

            case 'Process::async':
                // Printing the value
                echo parent::$core::$tasker::run( 'process', 'async' );
            break;

            case 'Queue::process':
                // (Processing the queue)
                Queue::create
                (
                    [
                        '1',
                        '2',
                        '3',
                        '4',
                        '5',
                        '6',
                        '7',
                        '8',
                        '9',
                        '10',
                        '11'
                    ]
                )
                    ->process
                    (
                        function ($element)
                        {
                            // Printing the value
                            echo "$element<br>";
                        }
                    )
                ;
            break;



            case 'XML::change':
                // (Creating an XMLDocument)
                $xml_document = XMLDocument::read( File::select( parent::$core::$basedir . '/../web/cdn/cd.xml' )->read() );



                // (Getting the value)
                $nodes = $xml_document->execute( '/CATALOG/CD/TITLE[ text()="Eros" ]/following-sibling::ARTIST[ text()="Eros Ramazzotti" ]/following-sibling::PRICE' );
                
                // (Getting the value)
                $node = $nodes[0];
                $node->nodeValue = '30';



                // (Setting the header)
                header('Content-Type: application/xml');

                // Printing the value
                echo $xml_document;
            break;



            case 'ZIP::build':
                // (Emptying the directory)
                Directory::select( parent::$core::$basedir . '/../web/cdn/zip' )->empty();



                // Returning the value
                return
                    ZipArchive::select( parent::$core::$basedir . '/../web/cdn/zip/archive.zip' )->build( parent::$core::$basedir . '/../web/cdn/3' )
                ;
            break;

            case 'ZIP::extract':
                // Returning the value
                return
                    ZipArchive::select( parent::$core::$basedir . '/../web/cdn/zip/archive.zip' )->extract( parent::$core::$basedir . '/../web/cdn/zip/archive' )
                ;
            break;
        }
    }
}



?>