@extends('layouts/empty.blade.php')

@section('view.content')

    <style>

        body
        {
            background-color: green;
        }

    </style>

    

@endsection



@section('view.script')

    <script>

        // (Setting the values)
        let connection = null;
        let counter    = 0;



        // (Listening for the events)
        $(window).on('load', function () {
            // (Creating a Connection)
            connection = new Solenoid.SSE.Connection
            (
                '',
                new Solenoid.SSE.Request
                (
                    {
                        'X-SSE-Client': '0987'
                    },

                    JSON.stringify
                    (
                        {
                            'user': 'user'
                        }
                    )
            )
            )
            ;

            // (Listening for the event)
            connection.addEventListener( 'timeupdate', function (event) {
                // (Appending the value)
                $('body').append( '<div>' + ++counter + ' -> ' + JSON.parse( event.data )['datetime'] + '</div>' );
            });



            // (Opening the connection)
            connection.open();
        });

        $(window).on('unload', function () {
            // (Closing the connection)
            connection.close();
        });

    </script>

@endsection