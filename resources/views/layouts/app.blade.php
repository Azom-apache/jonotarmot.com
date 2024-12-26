<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/x-icon" href="{{asset('images/apps/favicon.ico')}}">
  <title>Web Poll</title>
  <!-- Fonts and icons -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
 
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.0.4') }}" rel="stylesheet" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-json/2.6.0/jquery.json.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet" />
  <link href="assets/css/select2.min.css" rel="stylesheet" />
  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
   
  <style>
    .toast-middle-center {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translateX(-50%);
    }
    .toast {
      height: 80px;
      padding: 20px;
      line-height: 1.5;
      font-size: 16px;
    }
    .toast {
      background-color: #D81B60; /* Red background color */
      color: #fff; /* White text color */
    }
    .search_container {
    position: relative;
}

#searchResults {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    max-height: 200px; /* Adjust as needed */
    overflow-y: auto;
    display: none; /* Initially hidden */
}
#sidenav-collapse-main {
        height: 80%; 
        overflow-y: auto; 
    }
    html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}

.main-content {
    flex: 1;
}

.footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    background-color: #f8f9fa; /* Adjust as necessary */
}

.footer .container-fluid {
    display: flex;
    justify-content: center;
    align-items: center;
}

  </style>
</head>
<!-- body background  bg-gray-200 -->
        <body class="g-sidenav-show">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs  fixed-start ms-3   bg-gradient-dark " id="sidenav-main">
    <div class="sidenav-header">
      <br>
      <img src="{{asset('images/apps/logo.png')}}" height="60" width="200px" >
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
      <li class="nav-item">
    <a class="nav-link text-white {{ Request::route()->getName() == 'dashboard' ? 'active bg-gradient-primary' : '' }}" href="{{route('dashboard')}}">
        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
        </div>
        <span class="nav-link-text ms-1">{{translate('Dashboard')}}</span>
    </a>
</li>


          <li class="nav-item">
          <a class="nav-link text-white }">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa fa-user me-sm-1"></i>
            </div>
            <span class="nav-link-text ms-1">{{translate('Profile')}}</span>
          </a>
        </li>
     
      <li class="nav-item">
          <a class="nav-link text-white" href="#">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fas fa-circle me-1" id="statusIcon"></i>
                  <span id="onlineText"><?php echo $user->is_online == 1 ? 'Online' : 'Offline'; ?></span>
                  <label class="switch ms-2">
                      <input type="checkbox" id="onlineStatus" <?php echo $user->is_online == 1 ? 'checked' : ''; ?>>
                      <span class="slider round"></span>
                  </label>
              </div>
          </a>
      </li>
       
      </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <ul class="navbar-nav">
      <li class="nav-item">
          <a class="nav-link text-white " href="{{ route('logout') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">login</i>
            </div>
            <span class="nav-link-text ms-1">{{translate('Log Out')}}</span>
          </a>
        </li></ul>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg" >
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
         
        </nav>
        
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="search_container position-relative">
                <input type="text" id="username" placeholder="Search Friends..." class="search__box form-control" autocomplete="off">
                <i class="fas fa-search search__icon" id="icon" onclick="toggleShow()"></i>
                <div id="searchResults" class="dropdown-menu w-100 text-center"></div> 
            </div>
        </div>

          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          
          <form action="{{ route('setLocale') }}" method="POST">
          @csrf
          <select name="locale" onchange="this.form.submit()" class="search__box form-control">
              @foreach(getLanguages() as $language)
                  @if($language->translation_status != null)
                      <option value="{{ $language->code }}"
                          {{ (session('locale', 'en') == $language->code) ? 'selected' : '' }}>
                          {{ $language->name }}
                      </option>
                  @endif
              @endforeach
          </select>
      </form>

          </div>
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          </div>
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          
        <div class="input-group input-group-outline">
        <div align="center">
            <p class="mb-0" style="font-size: 12px; font-weight: bold;">{{ $user->first_name }} {{ $user->last_name }}</p>
            <p class="mb-0" style="font-size: 11px;">{{ $user->username }}</p>
          </div>
        @if($user->profile_pic)
          <img src="{{ asset('images/users/' . $user->profile_pic) }}" class="rounded-circle ms-1" height="40px" width="40px">
        @else
          <img src="{{ asset('images/users/avatar.jpg') }}" class="rounded-circle ms-1" height="40px" width="40px">
        @endif

  </div>
</div>
      <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            </ul>
        </div>
      </div>
    </nav>
    <div class="container-fluid py-4">
        <!-- partial -->
        @yield('content')
        <!-- Footer -->
      </div>
  </main>
  {{-- <footer class="footer py-4 fixed-bottom">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-center">
            <div class="col-12">
                <div class="copyright text-center text-sm text-muted">
                    © <script>
                        document.write(new Date().getFullYear())
                    </script>,{{translate('made with')}} <i class="fa fa-heart"></i> by
                    <a href="#" class="font-weight-bold">Hey Pal</a>
                </div>
            </div>
        </div>
    </div>
</footer> --}}
  <!--   Core JS Files   -->

  <div class="modal fade" id="pendingCallModal" tabindex="-1" role="dialog" aria-labelledby="pendingCallModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pendingCallModalLabel">{{translate('Incoming Call')}}</h5>
               
            </div>
            <div class="modal-body">
                <p>{{translate('Incoming CallYou have an incoming call. Do you want to accept it?')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="acceptCallBtn" class="btn btn-success">{{translate('Accept')}}</button>
                <button type="button"id="rejectCallBtn" class="btn btn-primary" data-dismiss="modal">{{translate('Reject')}}</button>
            </div>
        </div>
    </div>
</div>

  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script type="module" src="{{ asset('assets/js/firebase-config.js') }}"></script>


  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script src="{{ asset('assets/js/core/buttons.js') }}"></script>
<script src="{{ asset('assets/js/material-dashboard.min.js?v=3.0.4') }}"></script>
<script src="{{ asset('custom-js/cloud_versionJs.js') }}"></script>


@yield('scripts')
 
<script>
function goBack() {
  window.history.back();
}

function toggleShow () {
  var el = document.getElementById("box");
  el.classList.toggle("show");
}


</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleButton = document.getElementById('iconNavbarSidenav');
        const sideNav = document.getElementById('sidenav-main');
        const body = document.querySelector('body');

        toggleButton.addEventListener('click', function() {
            sideNav.classList.toggle('show');
            body.classList.toggle('g-sidenav-show');
        });
    });
</script>

</body>

</html>