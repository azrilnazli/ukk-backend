
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VireStream @yield('title')</title>

  <!-- MIX CSS -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <script src="https://use.fontawesome.com/64e14a18d4.js"></script>
  <script type="text/javascript" src="/js/jquery/1.9.1/jquery.min.js"></script>

  @yield('head')
</head>


  <body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        {{-- <span class="h3 text-secondary"> <i class="fas fa-video text-danger"></i> Video Management System</span> --}}
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      {{-- <li class="nav-item">
        <img style="height:40px" class="img-fluid" src="/images/logo.png" />
      </li> --}}
      <li class="nav-item">

        <a class="nav-link"
           role="button"
           onclick="event.preventDefault();
           document.getElementById('logout-form').submit();">
            <i class='fas fa-sign-out-alt' style='font-size:22.5px;color:red'></i>
        </a>
      </li>

    </ul>
  </nav>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
  </form>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @if( isset(Auth::user()->profile->photo) && Auth::user()->profile->photo == 1 )
          <img src="{{ Storage::disk('public')->url("/avatars/" . Auth::user()->id . '.png') }}"  class="img-circle elevation-2" alt="User Image">
          @else
          <img src="{{ asset('admin-lte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
          @endif
        </div>
        <div class="info">
            <small>
          <a href="/profile" class="d-block">{{ Str::limit (Auth::user()->email, 25)  }}</a>
            </small>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
      @include('partials.side_menu')
      </nav>

      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">

      <!-- system alerts -->
      @if ($message = Session::get('success'))
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="alert alert-success" role="alert">
              {{ $message }}
          </div>
        </div>
      </div>
      @endif

      @if ($errors->any())
      <div class="row justify-content-center">
        <div class="col-md-10">


          <div class="pt-3 alert alert-danger">
              <ul >
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>


        </div>
      </div>
      @endif


    <div class="container-fluid">

      <div class="row justify-content-center">
            <div class="col-5">
                <h4><i class="fa fa-info-circle" aria-hidden="true"></i> <u>@yield('title')</u></h4>
            </div>

            <div class="col-5">
                @yield('breadcrumb')
            </div>
      </div>
      <hr class="col-10" />
    </div>



    <!-- Main content -->
      <div class="row justify-content-center">
        <div class="col-md-10">

          @yield('content')
        </div>
      </div>
    <!-- /.content -->

  </div><!-- ./header -->
</div><!-- ./wrapper -->




  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      VireServe SDN BHD
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="http://vireserve.com">Cloud Connect SDN BHD</a>.</strong> All rights reserved.
  </footer>


</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- MIX JS -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('script')
</body>
</html>
