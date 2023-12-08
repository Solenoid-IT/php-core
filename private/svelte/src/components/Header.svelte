<script>

    import { user } from '../stores/user.js';

    import { onMount } from "svelte";



    onMount
    (
        function ()
        {
            // (Logging the value)
            console.log('Header component has been mounted !');
        }
    )
    ;

</script>



<div class="header">
    <a class="username-box" rel="external" href="/" style="text-decoration: none;">
        { $user ? $user.username : '' }
    </a>
</div>



<style>

    .header
    {
        width: 100%;
        padding: 10px 20px;
        background-color: #dbdbdb;
    }

    .username-box
    {
        font-size: 16px;
        font-weight: 700;
    }

</style>