<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @include ('assets/head.blade.php')

        @yield ('view.head')
    </head>

    <body>
        @include ('components/header.blade.php')

        <div id="layoutSidenav">
            @include ('components/sidebar.blade.php')

            <div id="layoutSidenav_content">
                <main class="page-main">
                    <div class="container-fluid px-4">
                        @yield ('view.body')
                    </div>
                </main>

                @include ('components/footer.blade.php')
            </div>
        </div>



        @include ('assets/body.blade.php')

        @yield ('view.script')



        <script>
        
            // (Logging the value)
            console.log('Base layout has been loaded !');
        
        </script>
    </body>
</html>
