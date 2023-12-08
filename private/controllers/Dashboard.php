<?php



namespace App\Controller;



use \Solenoid\Core\MVC\Controller;

use \App\Model\User as UserModel;
use \App\Model\Visitor as VisitorModel;

use \App\Store\Session\User as UserSessionStore;






class Dashboard extends Controller
{
    # Returns [void]
    public function get ()
    {
        // (Initializing the store)
        UserSessionStore::init();

        // (Getting the value)
        $session = UserSessionStore::$data['session'];



        // (Getting the value)
        $report =
        [
            'monthly' => VisitorModel::list_monthly_report(),
            'yearly'  => VisitorModel::list_yearly_report()
        ]
        ;



        // (Printing the value)
        echo parent::$core::$view::build
        (
            'root/Dashboard/view.blade.php',
            [
                'username' => UserModel::find( 'id', $session->data['id'] )[ 'username' ],

                'visitors' => VisitorModel::list()
            ],
            [
                'charts'   =>
                [
                    'currentMonthVisitors' =>
                    [
                        'labels' => array_map( function ($record) { return $record['day']; }, $report['monthly'] ),
                        'data'   => array_map( function ($record) { return $record['qty']; }, $report['monthly'] )
                    ],

                    'currentYearVisitors' =>
                    [
                        'labels' => array_map( function ($record) { return $record['month']; }, $report['yearly'] ),
                        'data'   => array_map( function ($record) { return $record['qty']; }, $report['yearly'] )
                    ]
                ]
            ]
        )
        ;
    }
}



?>