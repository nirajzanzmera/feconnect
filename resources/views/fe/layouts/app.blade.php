<!DOCTYPE html>
<html class="bootstrap-layout"  lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="apple-itunes-app" content="app-id=1591796916, app-argument=connect.dataczar.com">
        <meta name="robots" content="noindex">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Connect - {{ $page_title ?? ucwords(str_replace('.', ' ', str_replace(['index', 'show'], '', Route::currentRouteName()))) }}</title>
        <!-- Material Design Icons  -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- Roboto Web Font -->
        <link href="https://fonts.googleapis.com/css?family=Lato:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en" rel="stylesheet">
        <!-- App CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link type="text/css" href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/print.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/tiny.css') }}" rel="stylesheet">
        
        <!-- Vendor CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/fontawesome/4.5.0/css/font-awesome.min.css">

        @yield('css')

        <?php
        $dark = "";
        if(session('home_data')['data']->data->team->settings->preference == 'dark'){
            $dark = "dark";
        }
        ?>

        @include('fe.layouts._css')
        @include('fe.layouts._fav')
        @include('fe.layouts._pixels')
    </head>
    <body class="layout-container top-navbar si-l3-md-up">
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KF37SJR" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->

        @yield('modal')
        <!-- Navbar -->
        @include('fe.layouts._nav')
        <!-- // END Navbar -->
        <!-- Sidebar -->
       @include('fe.layouts._sidebar')
        <!-- // END Sidebar -->
    <!-- Right Sidebars -->
    @yield('right-sidebar')
    <!-- Content -->
    <div class="layout-content ls-top-navbar-md-up">
        <div class="container-fluid">
            @include('fe.layouts._alerts')
        </div>
        <div class="container-fluid" style="padding-bottom: 150px;">
            @yield('content')
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('assets/vendor/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/vendor/tether.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap.min.js') }}"></script>
    <!-- AdminPlus -->
    <script src="{{ asset('assets/vendor/adminplus.js') }}"></script>
    <!-- App JS -->
    <script src="{{ asset('assets/js/main.min.js') }}"></script>
    <!-- Theme Colors -->
    <script src="{{ asset('assets/js/colors.js') }}"></script>

    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
    var state = ' {{ session('sidebar') }}';
    
    @if(session('sidebar') == 'collapsed')
    collapseIt();
    @else
    uncollapseIt();
    @endif
    $('.toggleSideBar').click(function(e) {
    e.preventDefault();
    if (state == 'collapsed'){
    uncollapseIt();
    } else {
    collapseIt();
    }
    });
    function collapseIt() {
    $('.side-bar-label').hide();
    $('.toggle-icon').html('chevron_right');
    $('#sidebarLeft').width( "60px" );
    $('.si-l3-md-up>.layout-content, .si-l3-md-up>.st-container>.st-pusher>.st-content>.layout-content').css( { "margin-left" : "60px" });
    state = 'collapsed';
    $.get('{{ route('sidebar', ['state'=>'collapsed']) }}');
    }
    function uncollapseIt () {
    $('.side-bar-label').show();
    $('.toggle-icon').html('chevron_left');
    $('#sidebarLeft').width( "250px" );
    $('.si-l3-md-up>.layout-content, .si-l3-md-up>.st-container>.st-pusher>.st-content>.layout-content').css( { "margin-left" : "250px" });
    state = 'uncollapsed';
    $.get('{{ route('sidebar', ['state'=>'uncollapsed']) }}');
    }
    function sideBarHack() {
        if ($(window).width() < 767) {
            //REMOVE PADDING
            $('.si-l3-md-up>.layout-content, .si-l3-md-up>.st-container>.st-pusher>.st-content>.layout-content').css( { "margin-left" : "0" });
        } else {
            $('.layout-content').css( { "margin-left" : "250px" });
            if (state=='collapsed'){
                $('.layout-content').css( { "margin-left" : "60px" });
            }

            if(state == 'uncollapsed') {
                $('.si-l3-md-up>.layout-content, .si-l3-md-up>.st-container>.st-pusher>.st-content>.layout-content').css( { "margin-left" : "250px" });
            } else {
                $('.si-l3-md-up>.layout-content, .si-l3-md-up>.st-container>.st-pusher>.st-content>.layout-content').css( { "margin-left" : "60px" });
            }
        }
    } 
    $(window).resize(function() {
    sideBarHack();
    });
    sideBarHack();
    });
    localStorage.setItem('icon_url', "{{ route('content.flaticon.search') }}");
    </script>
    <!-- Start of dataczar Zendesk Widget script -->
    <script>
        /*<![CDATA[*/window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement("iframe");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src="javascript:false",r.title="",r.role="presentation",(r.frameElement||r).style.cssText="display: none",d=document.getElementsByTagName("script"),d=d[d.length-1],d.parentNode.insertBefore(r,d),i=r.contentWindow,s=i.document;try{o=s}catch(e){n=document.domain,r.src='javascript:var d=document.open();d.domain="'+n+'";void(0);',o=s}o.open()._l=function(){var e=this.createElement("script");n&&(this.domain=n),e.id="js-iframe-async",e.src="https://assets.zendesk.com/embeddable_framework/main.js",this.t=+new Date,this.zendeskHost="dataczar.zendesk.com",this.zEQueue=a,this.body.appendChild(e)},o.write('<body onload="document._l();">'),o.close()}();
        /*]]>*/
        zE( function () {
        var userName = "{!! $team->owner->name !!}";
        var userEmail = "{{ $team->owner->email }}";
        zE.identify({name: userName, email: userEmail});
        });
    </script>
    <!-- End of dataczar Zendesk Widget script -->
    @yield('js')
    @yield('js2')
    <script src="{{ mix('/stuff/notifications.js') }}"></script>
</body>

</html>
