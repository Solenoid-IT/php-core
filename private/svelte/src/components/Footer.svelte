<script>

    import { onMount } from 'svelte';



    // (Setting the value)
    let appVersion = null;



    onMount
    (
        function ()
        {
            // (Getting the value)
            appVersion = window.appVersion;

            // (Logging the value)
            console.log('Footer component has been mounted !');
        }
    )
    ;

</script>



<div class="footer">
    <div class="float-left d-none d-sm-inline-block">
        <b>Version</b>

        <!-- svelte-ignore missing-declaration -->
        <span style="margin: 0 6px;"> { appVersion }</span>
    </div>

    <div class="float-right">
        <strong>Copyright &copy; { new Date().getFullYear() } <a href="https://github.com/Solenoid-IT/php-core" target="_blank">App X</a></strong> <span style="margin: 0 6px;">-</span> All rights reserved
    </div>
</div>



<style>

    .footer
    {
        width: 100%;
        padding: 10px 20px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        background-color: #dbdbdb;
    }

</style>