<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @include ('assets/head.blade.php')

        @yield ('view.head')
    </head>

    <body>
        @yield ('view.body')



        @include ('assets/body.blade.php')

        @yield ('view.script')



        <script>
        
            // (Logging the value)
            console.log('Empty layout has been loaded !');
        
        </script>
    </body>
</html>
