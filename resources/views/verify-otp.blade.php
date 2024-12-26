<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/x-icon" href="{{asset('images/apps/favicon.ico')}}">
  <title>
    Hey Pal
  </title>
<!-- Fonts and icons -->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
<!-- Nucleo Icons -->
<link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
<!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
<!-- Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
<!-- CSS Files -->
<link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.0.4') }}" rel="stylesheet" />

  
</head>
<style>
    .background-image {
        background-image: url('{{ asset("images/apps/loginbg.jpg") }}');
        background-size: cover; /* Cover the entire background */
        background-position: center; /* Center the background image */
    }
</style>

<body class="bg-gray-200">
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100 bg-gray-200 background-image">
      <span class="mask bg-gray-200 opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
        <div align="center" style="margin-top:5px">
          <div class="col-lg-4 col-md-8 col-12 mx-auto"  align="center">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
                        @if ($errors->any())
                <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                </div>
            @endif
            @if(isset($otp_mismatch))
                  <div class="alert alert-danger">
                      {{ $otp_mismatch }}
                  </div>
              @endif
              <div class="card-body">
                <h6><img src="{{asset('images/apps/logo.png')}}" height="90px" width="270px"></h6>
                <!-- <p style="font-size:16px" class="text-warning">Hey Pal</p> -->
                <p style="font-size: 12px;">Please check your email and submit the OTP</p>
                <form method="POST" action="{{ route('otpVerification') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="otp" id="otp" class="form-control" placeholder="Enter your OTP" required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-warning">Submit</button>
                </form>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </main>
  <!--   Core JS Files   -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>

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
  <!-- Github buttons -->
  <script async defer src="{{ asset('assets/js/buttons.js') }}"></script>
<script src="{{ asset('assets/js/material-dashboard.min.js?v=3.0.4') }}"></script>

</body>

</html>