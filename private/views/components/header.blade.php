<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="/">
        App X
    </a>

    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
        </div>
    </form>

    <!-- GitHub Link -->
    <a class="btn btn-link btn-sm me-2" href="https://github.com/Solenoid-IT/php-core" target="_blank" title="GitHub Link">
        <i class="fa-brands fa-github" style="height: 20px; color: #9a9c9e;"></i>
    </a>

    <!-- Fullscreen Button -->
    <button class="btn btn-link btn-sm me-2" id="fullscreen_button" title="Fullscreen ON/OFF">
        <i class="fa-solid fa-expand" style="height: 20px; color: #9a9c9e;"></i>
    </button>

    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                {{--
                <li><a class="dropdown-item" href="#!">Settings</a></li>
                <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                <li><hr class="dropdown-divider" /></li>
                --}}

                <li><a class="dropdown-item" href="/logout">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>



<script>

    // (Click-Event on the element '#fullscreen_button')
    $('#fullscreen_button').on('click', function () {
        if ( window.fullScreen )
        {// Value is true
            // (Exiting from the fullscreen)
            document.exitFullscreen();
        }
        else
        {// Value is false
            // (Requesting the fullscreen)
            document.body.requestFullscreen();
        }
    });

    // (KeyUp-Event on the element window)
    $(window).on('keyup', function (event) {
        if ( document.activeElement !== document.body )
        {// Match failed
            // Returning the value
            return;
        }



        if ( event.key === 'f' )
        {// Match OK
            // (Triggering the event)
            $('#fullscreen_button').trigger('click');
        }
    });

</script>