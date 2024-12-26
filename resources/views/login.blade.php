<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/apps/favicon.ico') }}">
    <title>
        MCMS
    </title>
    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.0.4') }}" rel="stylesheet" />

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>

<body class="bg-gray-200">
    <div class="page-header min-vh-100">
        <div class="container">
            <div class="row">
                <div class="col-8 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 justify-content-end flex-column"
                    style="background-image: url('../images/apps/loginbg.png'); background-size: cover; background-position: center;">

                </div>
                <div class="col-lg-3 d-flex flex-column ms-auto">
                    <img src="{{ asset('images/apps/logo.png') }}"alt="Logo">
                    <div class="card card-plain">
                        @if ($errors->any())
                            <div class="alert alert-danger text-white">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                        <div class="card-body" align="center">
                            <h3>Credentials</h3>
                            <form method="POST" action="/logincheck">
                                @csrf
                                <div class="form-group" align="left">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="Enter Your Email" required>
                                </div>
                                <div class="form-group" align="left">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Enter Your Password" required>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-warning">Login</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer pt-0 px-lg-2 px-1">
                        <p class="mb-2 text-sm mx-auto">
                            Forgot password?
                            <a href="/register" class="text-primary text-gradient font-weight-bold">Register</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#date_of_birth').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true
            });
        });
    </script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script>
        const showPasswordButton = document.querySelector('#showPassword');
        const passwordInput = document.querySelector('#password');

        showPasswordButton.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                showPasswordButton.innerHTML = '<i class="fa fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                showPasswordButton.innerHTML = '<i class="fa fa-eye"></i>';
            }
        });
    </script>



</body>

</html>
