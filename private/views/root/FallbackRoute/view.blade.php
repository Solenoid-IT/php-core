@extends('layouts/empty.blade.php')

@section('view.head')

    <title>
        ROUTE NOT FOUND
    </title>

@endsection

@section('view.body')
    
    <div id="layoutError">
        <div id="layoutError_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="text-center mt-4">
                                <img class="mb-4 img-error" src="/assets/tpl/sb-admin/dist/assets/img/error-404-monochrome.svg" />
                                <p class="lead">This requested URL was not found on this server.</p>
                                <a href="/">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Return to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutError_footer">
            @include ('components/footer.blade.php')
        </div>
    </div>

@endsection



@section('view.script')

    <script>

        // (Logging the value)
        console.log('404 page has been loaded !');

    </script>

@endsection