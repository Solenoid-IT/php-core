<?php



namespace App\Model;



use \Solenoid\Core\MVC\Model;
use \Solenoid\Vector\Vector;
use \Solenoid\MySQL\QueryRunner;

use \App\Store\Connection\MySQL as MySQLConnectionStore;



class User extends Model
{
    # Returns [string|false] | Throws [Exception]
    public static function register (array $kv_data)
    {
        // (Initializing the store)
        MySQLConnectionStore::init();

        // (Getting the value)
        $mysql_connection = MySQLConnectionStore::$data['demo'];



        if ( !QueryRunner::create( $mysql_connection, 'core_demo', 'user' )->insert( $kv_data ) )
        {// (Unable to insert the record)
            // (Setting the value)
            $message = "Unable to insert the record";

            // Throwing an exception
            throw new \Exception($message);

            // Returning the value
            return false;
        }



        // Returning the value
        return $mysql_connection->get_last_insert_id();
    }

    # Returns [bool] | Throws [Exception]
    public static function unregister (string $id)
    {
        // (Initializing the store)
        MySQLConnectionStore::init();

        // (Getting the value)
        $mysql_connection = MySQLConnectionStore::$data['demo'];



        if ( !QueryRunner::create( $mysql_connection, 'core_demo', 'user' )->where( 'id', '=', $id )->delete() )
        {// (Unable to delete the record)
            // (Setting the value)
            $message = "Unable to delete the record :: " . $mysql_connection->get_error_text();

            // Throwing an exception
            throw new \Exception($message);

            // Returning the value
            return false;
        }



        // Returning the value
        return true;
    }



    # Returns [assoc|false] | Throws [Exception]
    public static function change (string $id, array $kv_data)
    {
        // (Initializing the store)
        MySQLConnectionStore::init();

        // (Getting the value)
        $mysql_connection = MySQLConnectionStore::$data['demo'];



        if ( !QueryRunner::create( $mysql_connection, 'core_demo', 'user' )->where( 'id', '=', $id )->update( $kv_data ) )
        {// (Unable to update the record)
            // (Setting the value)
            $message = "Unable to update the record";

            // Throwing an exception
            throw new \Exception($message);

            // Returning the value
            return false;
        }



        // Returning the value
        return true;
    }



    # Returns [assoc|false] | Throws [Exception]
    public static function find (string $key, string $value)
    {
        // (Initializing the store)
        MySQLConnectionStore::init();

        // (Getting the value)
        $mysql_connection = MySQLConnectionStore::$data['demo'];



        // (Getting the value)
        $record = QueryRunner::create( $mysql_connection, 'core_demo', 'user', true )->set_column_separator()->where( $key, '=', $value )->select()->fetch_head();

        if ( $record === false )
        {// (Record not found)
            // Returning the value
            return false;
        }



        // Returning the value
        return $record;
    }

    # Returns [array<assoc>] | Throws [Exception]
    public static function list ()
    {
        // (Initializing the store)
        MySQLConnectionStore::init();

        // (Getting the value)
        $mysql_connection = MySQLConnectionStore::$data['demo'];



        // (Getting the value)
        $record_list = QueryRunner::create( $mysql_connection, 'core_demo', 'user' )->set_column_separator()->select()->to_array();



        // Returning the value
        return $record_list;
    }
}



?>