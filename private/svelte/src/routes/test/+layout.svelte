<script>

    import Header from '../../components/Header.svelte';
    import Footer from '../../components/Footer.svelte';

    import { onMount } from 'svelte';

    onMount
    (
        function ()
        {
            // (Logging the value)
            console.log('Layout component has been mounted !');
        }
    )
    ;

</script>



<div class="root">
    <Header/>

    <slot />

    <Footer/>
</div>



<style>


    .root
    {
        width: 100vw;
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

</style>
