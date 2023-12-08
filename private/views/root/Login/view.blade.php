@extends('layouts/empty.blade.php')

@section('view.head')

    <title>
        Login
    </title>

@endsection

@section('view.body')

    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                <div class="card-body">
                                    <form class="swg swg-form" id="login-form">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control input" name="username" value="user" placeholder="Username" data-required>
                                            <label>Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control input" name="password" value="pass" placeholder="Password" data-required>
                                            <label>Password</label>
                                        </div>

                                        <div class="form-check mb-3">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input input" name="remember">
                                                Remember
                                            </label>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center mt-4 mb-0">
                                            {{--<a class="small" href="password.html">Forgot Password?</a>--}}
                                            <button type="submit" class="btn btn-primary">
                                                Login
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    {{--<div class="small"><a href="register.html">Need an account? Sign up!</a></div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            @include ('components/footer.blade.php')
        </div>
    </div>

@endsection



@section('view.script')

    <script>

        // (Logging the value)
        console.log('Login page has been loaded !');



        // (Creating a Form)
        const loginForm = new Solenoid.SWG.Form( document.getElementById( 'login-form' ) );

        // (Listening for the event)
        loginForm.addEventListener('submit', async function (event) {
            // (Getting the value)
            const invalidInput = loginForm.validate(true);

            if ( Object.values( invalidInput ).length === 0 )
            {// (Input is valid)
                // (Getting the value)
                const input = loginForm.getInput();

                

                // (Sending an http request)
                const response = await Solenoid.HTTP.sendRequest
                (
                    '',
                    'RPC',
                    {
                        'Action': 'user::start_session'
                    },
                    JSON.stringify( input ),
                    'json'
                )
                ;

                if ( response.status.code !== 200 )
                {// (Request failed)
                    // (Alerting the value)
                    alert( response.body['error']['message'] );

                    // Returning the value
                    return;
                }



                // (Setting the location)
                window.location.href = '/';
            }
        });



    </script>

@endsection