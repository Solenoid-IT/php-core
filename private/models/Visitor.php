<?php



namespace App\Model;



use \Solenoid\Core\MVC\Model;
use \Solenoid\MySQL\QueryRunner;

use \App\Store\Connection\MySQL as MySQLConnectionStore;



class Visitor extends Model
{
    # Returns [bool] | Throws [Exception]
    public static function register (array $kv_data)
    {
        // (Initializing the store)
        MySQLConnectionStore::init();

        // (Getting the value)
        $mysql_connection = MySQLConnectionStore::$data['demo'];



        if ( !QueryRunner::create( $mysql_connection, 'core_demo', 'visitor' )->insert( $kv_data ) )
        {// (Unable to insert the record)
            // (Setting the value)
            $message = "Unable to insert the record";

            // Throwing an exception
            throw new \Exception($message);

            // Returning the value
            return false;
        }



        // Returning the value
        return true;
    }

    # Returns [bool] | Throws [Exception]
    public static function unregister (string $id)
    {
        // (Initializing the store)
        MySQLConnectionStore::init();

        // (Getting the value)
        $mysql_connection = MySQLConnectionStore::$data['demo'];



        if ( !QueryRunner::create( $mysql_connection, 'core_demo', 'visitor' )->where( 'id', '=', $id )->delete() )
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



        if ( !QueryRunner::create( $mysql_connection, 'core_demo', 'visitor' )->where( 'id', '=', $id )->update( $kv_data ) )
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
        $record = QueryRunner::create( $mysql_connection, 'core_demo', 'visitor', true )->set_column_separator()->where( $key, '=', $value )->select()->fetch_head();

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
        $record_list = QueryRunner::create( $mysql_connection, 'core_demo', 'visitor' )->set_column_separator()->order_by( [ 'datetime.insert' => 'desc' ] )->select()->to_array();



        // Returning the value
        return $record_list;
    }



    # Returns [array<assoc>] | Throws [Exception]
    public static function list_monthly_report (?string $year = null, ?string $month = null)
    {
        if ( $year === null ) $year = date('Y');
        if ( $month === null ) $month = date('m');



        // (Initializing the store)
        MySQLConnectionStore::init();

        // (Getting the value)
        $mysql_connection = MySQLConnectionStore::$data['demo'];



        // (Setting the value)
        $query =
            '
                SELECT
                    YEAR(visitor_table.`datetime.insert`) AS `year`,
                    MONTH(visitor_table.`datetime.insert`) AS `month`,
                    DAY(visitor_table.`datetime.insert`) AS `day`,

                    COUNT(*) AS `qty`
                FROM
                    `visitor` visitor_table
                WHERE
                    YEAR(visitor_table.`datetime.insert`) = {{ year }}
                        AND
                    MONTH(visitor_table.`datetime.insert`) = {{ month }}
                GROUP BY
                    YEAR(visitor_table.`datetime.insert`),
                    MONTH(visitor_table.`datetime.insert`),
                    DAY(visitor_table.`datetime.insert`)
                ORDER BY
                    YEAR(visitor_table.`datetime.insert`) ASC,
                    MONTH(visitor_table.`datetime.insert`) ASC,
                    DAY(visitor_table.`datetime.insert`) ASC
                ;
            '
        ;

        // (Getting the value)
        $record_list = QueryRunner::create( $mysql_connection, 'core_demo' )
            ->set_column_separator()
            ->raw( $query, [ 'year' => $year, 'month' => $month ] )
            ->to_array
            (
                function ($record)
                {
                    // (Getting the value)
                    $record['year']  = (int) $record['year'];
                    $record['month'] = (int) $record['month'];
                    $record['day']   = (int) $record['day'];

                    $record['qty']   = (int) $record['qty'];



                    // Returning the value
                    return $record;
                }
            )
        ;



        // (Getting the value)
        $last_day_of_month = (int) ( new \DateTime( "$year-$month" ) )->modify('last day of this month')->format('d');



        // (Setting the value)
        $list = [];

        for ($i = 0; $i < $last_day_of_month; $i++)
        {// Iterating each entry
            // (Getting the value)
            $day = $i + 1;

            // (Getting the value)
            $result = array_filter( $record_list, function ($record) use ($day) { return $record['day'] === $day; } );
            $result = $result ? array_values( $result )[0] : null;



            // (Getting the value)
            $result =
                $result
                    ??
                [
                    'year'  => $record_list[0]['year'],
                    'month' => $record_list[0]['month'],
                    'day'   => $day,

                    'qty'   => 0
                ]
            ;
            $result =
            [
                'year'  => $result['year'],
                'month' => str_pad( $result['month'], 2, '0', STR_PAD_LEFT ),
                'day'   => str_pad( $result['day'], 2, '0', STR_PAD_LEFT ),

                'qty'   => $result['qty']
            ]
            ;



            // (Appending the value)
            $list[] = $result;
        }



        // Returning the value
        return $list;
    }

    # Returns [array<assoc>] | Throws [Exception]
    public static function list_yearly_report (?string $year = null)
    {
        if ( $year === null ) $year = date('Y');



        // (Initializing the store)
        MySQLConnectionStore::init();

        // (Getting the value)
        $mysql_connection = MySQLConnectionStore::$data['demo'];



        // (Setting the value)
        $query =
            '
                SELECT
                    YEAR(visitor_table.`datetime.insert`) AS `year`,
                    MONTH(visitor_table.`datetime.insert`) AS `month`,

                    COUNT(*) AS `qty`
                FROM
                    `visitor` visitor_table
                WHERE
                    YEAR(visitor_table.`datetime.insert`) = {{ year }}
                GROUP BY
                    YEAR(visitor_table.`datetime.insert`),
                    MONTH(visitor_table.`datetime.insert`)
                ORDER BY
                    YEAR(visitor_table.`datetime.insert`) ASC,
                    MONTH(visitor_table.`datetime.insert`) ASC
                ;
            '
        ;

        // (Getting the value)
        $record_list = QueryRunner::create( $mysql_connection, 'core_demo' )
            ->set_column_separator()
            ->raw( $query, [ 'year' => $year ] )
            ->to_array
            (
                function ($record)
                {
                    // (Getting the value)
                    $record['year']  = (int) $record['year'];
                    $record['month'] = (int) $record['month'];

                    $record['qty']   = (int) $record['qty'];



                    // Returning the value
                    return $record;
                }
            )
        ;



        // (Setting the value)
        $list = [];

        for ($i = 0; $i < 12; $i++)
        {// Iterating each entry
            // (Getting the value)
            $month = $i + 1;

            // (Getting the value)
            $result = array_filter( $record_list, function ($record) use ($month) { return $record['month'] === $month; } );
            $result = $result ? array_values( $result )[0] : null;



            // (Getting the value)
            $result =
                $result
                    ??
                [
                    'year'  => $record_list[0]['year'],
                    'month' => $month,

                    'qty'   => 0
                ]
            ;
            $result =
            [
                'year'  => $result['year'],
                'month' => str_pad( $result['month'], 2, '0', STR_PAD_LEFT ),

                'qty'   => $result['qty']
            ]
            ;



            // (Appending the value)
            $list[] = $result;
        }



        // Returning the value
        return $list;
    }
}



?>