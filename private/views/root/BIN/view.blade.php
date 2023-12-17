@extends('layouts/empty.blade.php')

@section('view.head')

    <title>
        BIN
    </title>



    <script src="https://cdn.solenoid.it/pjs/pjs.js"></script>

    <script>

        // (Setting the value)
        Solenoid.PJS.postfix = `ts=${ Math.floor( new Date().valueOf() / 1000 ) }`;

        // (Loading the packages)
        Solenoid.PJS.loadPackages
        (
            [
                'solenoid/bin'
            ]
        )
        ;

    </script>

@endsection

@section('view.body')

    <div class="m-auto p-5 d-table" style="width: 900px;">
        <div class="row">
            <div class="col">
                <input class="form-control" id="filepicker" type="file" multiple>
            </div>
            <div class="col">
                <button class="btn btn-primary" id="abort_transfer_button">
                    Abort Transfer
                </button>
            </div>
        </div>
    </div>

@endsection



@section('view.script')

    <script>

        // (Logging the value)
        console.log('BIN page has been loaded !');

    </script>

    <script name="transfer">

        // (Setting the value)
        transfer = null;



        // (Change-Event on the element)
        document.getElementById( 'filepicker' ).addEventListener('change', async function (event) {
            // (Creating a Transfer)
            transfer = new Solenoid.BIN.Transfer
            (
                {
                    //'endpointURL': 'https://core.demo.solenoid.it/bin',
                    //'credentials': true,
                    'data':        null,
                    'files':       this.files,
                    //'chunkSize':   1 * 1048576// 1 MB
                }
            )
            ;



            // (Listening for the events)
            transfer.addEventListener('statechange', function (event) {
                // (Consoling the value)
                console.debug( `STATE -> ${ event.data.state }` )
            });

            transfer.addEventListener('file.progress', function (event) {
                // (Consoling the value)
                console.debug( `${ event.data.file.name } -> ${ ( event.data.loaded / event.data.total ) * 100 } %` )
            });

            transfer.addEventListener('progress', function (event) {
                // (Consoling the value)
                //console.debug( `GLOBAL -> ${ ( event.data.loaded / event.data.total ) * 100 } %` )
            });



            // (Starting the transfer)
            const response = await transfer.start();

            // (Consoling the value)
            console.debug(response);
        });

        // (Click-Event on the element)
        document.getElementById( 'abort_transfer_button' ).addEventListener('click', function (event) {
            // (Aborting the transfer)
            transfer.abort();
        });

    </script>

@endsection