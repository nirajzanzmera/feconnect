<!DOCTYPE html>
<html class="bootstrap-layout"  lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="robots" content="noindex">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Connect - {{ $page_title ?? '' }}</title>
        <!-- Material Design Icons  -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- Roboto Web Font -->
        <link href="https://fonts.googleapis.com/css?family=Lato:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en" rel="stylesheet">
        <!-- App CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link type="text/css" href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet">
        
        <!-- Vendor CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/fontawesome/4.5.0/css/font-awesome.min.css">
        @yield('css')
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

       <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
                margin-top:-100px;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .code {
                border-right: 2px solid;
                font-size: 26px;
                padding: 0 15px 0 15px;
                text-align: center;
            }

            .message {
                font-size: 18px;
                text-align: center;
            }
       </style>
    </head>
    <body style="overflow:scroll;">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white navbar-full navbar-fixed-top hidden-print">
        
    
        <!-- Brand -->
        <a class="navbar-brand first-child-md" href="{{ route('home') }}">
            <img style="width: 200px;" src="{{ asset('img/dataczar-logo.png') }}">
        </a>
    
        <ul class="navbar-nav mr-auto">
        </ul>
    
        <!-- // END Menu -->
    </nav>
    
        <!-- // END Navbar -->
        <!-- Sidebar -->

    <!-- Content -->
    <div class="layout-">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('assets/vendor/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/vendor/tether.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap.min.js') }}"></script>
   

    


</body>

</html>
