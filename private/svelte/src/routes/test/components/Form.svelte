<script>

    import Modal from '../components/Modal.svelte';

    import { onMount } from 'svelte';

    onMount
    (
        function ()
        {
            // (Logging the value)
            console.log('Form component has been mounted !');
        }
    )
    ;



    // (Setting the values)
    let modalOpen = false;
    let ipInfo    = null;



    // Returns [void]
    async function onSubmit (event)
    {
        // (Preventing the default)
        event.preventDefault();



        // (Creating a Form)
        const form = new Solenoid.SWG.Form( event.target );



        // (Validating the form)
        const invalidInput = form.validate( true );



        // (Getting the value)
        const inputValid = Object.values( invalidInput ).length === 0;

        if ( inputValid )
        {// Value is true
            // (Sending an http request)
            const response = await Solenoid.HTTP.sendRequest
            (
                'https://api.solenoid.it/ip-info/1',
                'GET',
                {},
                '',
                'json'
            )
            ;

            // (Getting the value)
            ipInfo = response.body;
        }
        else
        {// Value is false
            // (Setting the value)
            ipInfo = null;
        }



        // (Getting the value)
        modalOpen = ipInfo !== null;
    }

</script>



<form class="swg swg-form m-auto d-table" on:submit={ ( event ) => { onSubmit( event ) } }>
    <div class="row">
        <input type="text" class="form-control input" name="username" placeholder="username" data-required>
    </div>

    <div class="row mt-4">
        <button type="submit" class="btn btn-primary m-auto">
            TEST
        </button>
    </div>
</form>



<Modal width={ 600 } bind:open={ modalOpen }>
    <div slot="title">
        IP
    </div>

    <div slot="body">
        <div class="row mt-2">
            <div class="col">
                <table class="kv-table">
                    <tbody>
                        <tr>
                            <th class="align-middle">
                                Address
                            </th>
                            <td class="align-middle">
                                { ipInfo['ip']['address'] }
                            </td>
                        </tr>
                        <tr>
                            <th class="align-middle">
                                Country
                            </th>
                            <td class="align-middle">
                                { ipInfo['geolocation']['country']['code'] } • { ipInfo['geolocation']['country']['name'] } • <img class="country-flag" src="{ ipInfo['geolocation']['country']['flag'] }" alt="">
                            </td>
                        </tr>
                        <tr>
                            <th class="align-middle">
                                ISP
                            </th>
                            <td class="align-middle">
                                { ipInfo['connection']['isp'] }
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</Modal>



<style>

    .swg.swg-form
    {
        width: 480px;
        padding: 10px;
        background-color: #ffffff;
    }

    .swg.swg-form button
    {
        width: 100px;
    }

</style>