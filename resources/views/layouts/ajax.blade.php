<html>
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
    
        @yield('content')
    </div>
<script src="{{ asset('js/app.js') }}"></script>
@yield('script')
</body>    
</html>