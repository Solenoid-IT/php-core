<svelte:head>
	<title>Test Page</title>
</svelte:head>

<script>

    import { user } from '../../stores/user.js';

    import Form from './components/Form.svelte';

    import { onMount } from 'svelte';

    onMount
    (
        function ()
        {
            // (Getting the value)
            $user = window.user;



            // (Logging the value)
            console.log('Page component has been mounted !');
        }
    )
    ;

</script>

<div class="main container">
    <Form />
</div>



<style>

    .main
    {
        display: flex;
        flex-grow: 1;
    }

</style>