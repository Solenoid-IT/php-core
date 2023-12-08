<?php

    use \Solenoid\Core\Core;

?>



<!-- DataTable -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css">

<!-- Template styles -->
<link rel="stylesheet" href="/assets/tpl/sb-admin/dist/css/styles.css">

<!-- Custom styles -->
<link rel="stylesheet" href="{{ Core::asset('/assets/styles/custom.css') }}">



<!-- FontAwesome -->
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

<!-- Luxon -->
<script src="https://www.solenoid.it/cdn/lib/js/luxon/luxon.min.js"></script>



<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>



<!-- Solenoid/HTTP -->
<script src="https://www.solenoid.it/cdn/lib/js/solenoid/solenoid.http.js"></script>

<!-- Solenoid/SSE -->
<script src="https://www.solenoid.it/cdn/lib/js/solenoid/solenoid.sse.js"></script>



<!-- SWG.Form -->
<script src="/assets/lib/solenoid/solenoid.swg.form.js"></script>



<script>

    // (Logging the value)
    console.log('Head assets have been loaded !');

</script>






<script name="set_locales">

    // (Setting the cookies)
    document.cookie = `timezone=${ encodeURI( Intl.DateTimeFormat().resolvedOptions().timeZone ) }`;
    document.cookie = `language=${ encodeURI( navigator.language ) }`;

</script>