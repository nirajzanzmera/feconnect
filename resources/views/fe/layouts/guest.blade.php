<!DOCTYPE html>
<html class="bootstrap-layout">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connect</title>
    <meta name="robots" content="noindex">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Material Design Icons  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Roboto Web Font -->
    <link
        href="https://fonts.googleapis.com/css?family=Lato:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en"
        rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
    <!-- App CSS -->
    <link type="text/css" href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/fontawesome/4.5.0/css/font-awesome.min.css">
    @yield('css')
    @include('fe.layouts._fav')
    @include('fe.layouts._pixels')
    <style>
        .logo {
            padding-top: 70px;
        }
        @media (max-width: 980px) {
            .logo {
                padding-top: 0;
            }
        }
    </style>
</head>

<body style="overflow: auto;">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KF37SJR" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <!-- Content -->

    <div class="container-fluid">
        @include('fe.layouts._alerts')
        @yield('content')
    </div>
    <div class="container-fluid">

    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/vendor/jquery.min.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('assets/vendor/tether.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap.min.js') }}"></script>

    @yield('js')

</body>

</html>