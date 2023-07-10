<style>
    .nav-avatar {
        top: 5px;
        margin: 0px;
        width: 48px;
        height: 48px;
        left: 0px;
    }

    .nav-avatar {
        position: absolute;
        top: 0px;
        bottom: 0px;
        left: 10px;
        margin: auto;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-top: 10%;
        font-size: 50px;
    }

    .user-info {
        padding-left: 58px;
        margin-top: 8px;
    }

    .user-info-name {
        color: rgb(51, 71, 91);
        font-weight: 600;
        font-size: 16px;
        white-space: pre-wrap;
        overflow-wrap: break-word;
    }
    .user-info-email {
        color: rgb(124, 152, 182);
        font-size: 12px;
        line-height: 20px;
        white-space: pre-wrap;
        overflow-wrap: break-word;
    }

    .user-info-preferences {
        color: #005cf7;
    }

    .userpreferences:hover .user-info-preferences {
        text-decoration: underline;
    }

    html.bootstrap-layout .layout-content.ls-top-navbar-md-up {
        height: calc(100% - 56px);
    }
    .navbar{
        margin-bottom:0px !important;
    }
    .top-navbar > .layout-content {
        padding-top: 0px !important;
    }

    @media (max-width: 767px){
        html.bootstrap-layout .layout-content.ls-top-navbar-md-up {
            margin-top: 56px;
        }
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-white {{--@impersonating navbar-dark bg-primary @else navbar-light bg-white @endimpersonating--}} navbar-full navbar-fixed-top hidden-print"
    @impersonating style="" @endimpersonating >
    <!-- Sidebar toggle -->
    <button class="navbar-toggler pull-xs-left hidden-md-up" style="border:0;" type="button" data-toggle="sidebar"
        data-target="#sidebarLeft">
        <span class="material-icons">menu</span>
        @if($team->status != 'active' && $team->status != 'freeze_silent')
            <div style="background-color: red;
                    height: 10px;
                    width: 10px;
                    border-radius: 50%;
                    margin-top:10px;
                    float: right;"></div>
        @endif

    </button>
    <!-- Navbar toggle -->

    <!-- Brand -->
    <a class="navbar-brand first-child-md" href="{{ route('home') }}">
        <img src="{{ asset('img/dataczar-logo.png') }}">
    </a>

    <ul class="navbar-nav mr-auto">
    </ul>

    <!-- Menu -->
    <ul class="navbar-nav ">

        {{--
        <li class=" hidden-sm-down" style="padding-right:10px;">
            API: {{\Illuminate\Support\Str::limit($g_user->email ?? '<no_user>',20,'...')}} RT: {{ sprintf("%0.1f",(microtime(true) - LARAVEL_START)) }}s
            <a href="{{route('logout')}}"><i class="fa fa-plug"></i></a>
        </li>
        <li class=" hidden-md-up"  style="padding-right:10px;">
            {{ sprintf("%0.1f",(microtime(true) - LARAVEL_START)) }}s
            <a href="{{route('logout')}}"><i class="fa fa-plug"></i></a>
        </li>
        --}}
        <li class=""  style="padding-right:10px;">
            {{ sprintf("%0.1f",(microtime(true) - LARAVEL_START)) }}
        </li>
        <!-- Authentication Links -->
        @if (empty($g_user->name))
        <li class="nav-item hidden-sm-down"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
        <li class="nav-item hidden-sm-down"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
        @else
        


        {{--
        @impersonating
        <li class="nav-item hidden-sm-down">
            <a href="#" class="nav-link"
                onclick="event.preventDefault(); document.getElementById('impersonating').submit();">
                <i class="fa fa-user-times" aria-hidden="true"></i> Stop Impersonating
            </a>
            <form action="{{ route('admin.impersonate') }}" method="POST" id="impersonating" class="hidden">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            </form>
        </li>
        @endimpersonating

        @if( !empty(session('currentTeam')) && auth()->user()->has_cs_basic )
        <li class="nav-item hidden-sm-down">
            <a href="{{ route('admin.account.manage', auth()->user()->currentTeam->id ) }}" class="nav-link">
                <i class="fa fa-user" aria-hidden="true"></i> Return
            </a>
        </li>
        <li class="nav-item hidden-sm-down">
            <a href="{{ route('admin.account.stop_managing', auth()->user()->currentTeam->id) }}" class="nav-link">
                <i class="fa fa-user-times" aria-hidden="true"></i> Stop Managing:
                {{ auth()->user()->currentTeam->name }}
            </a>
        </li>
        @endif
        --}}

        @include('fe.layouts._notifications')

        <li class="nav-item hidden-sm-down dropdown" style="padding-left:10px;">
            <a id="profile_menu" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                aria-haspopup="true" aria-expanded="false">
                <span class="material-icons">person
                    @if($team->status != 'active' && $team->status != 'freeze_silent')
                        <div style="background-color: red;
                             height: 10px;
                             width: 10px;
                             border-radius: 50%;
                             float: right;"></div>
                    @endif
                </span>

                {{--<span class="hidden-sm-down">--}}
                    {{--{{ $g_user->name }}--}}
                {{--</span> --}}
            </a>
            <div class="dropdown-menu dropdown-menu-right">

                {{--<a class="dropdown-item" href="{{ route('user.dashboard') }}">--}}
                    {{--<div>--}}
                    {{--<span class="material-icons">person</span>--}}

                        {{--{{ $g_user->name }}<br />--}}
                        {{--{{\Illuminate\Support\Str::limit($g_user->email ?? '<no_user>',20,'...')}} <br>--}}
                        {{--Profile & Preference--}}

                    {{--</div>--}}
                {{--</a>--}}

                <div class="userpreferences">
                    <a class="dropdown-item" data-tracking="click" id="userPreferences"
                       href="{{ route('user.dashboard') }}" aria-expanded="true">
                        <span class="material-icons nav-avatar">person</span>
                        <div class="user-info">
                            <div class="user-info-name">{{ $g_user->name }}</div>
                            <div class="user-info-email">{{\Illuminate\Support\Str::limit($g_user->email ?? '<no_user>',20,'...')}}</div>
                            <div class="user-info-preferences">Profile &amp; Preferences</div>
                        </div>
                    </a>
                </div>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('profile') }}">
                    <i class="sidebar-menu-icon material-icons">settings</i>
                     Settings
                </a>
                <a class="dropdown-item" href="{{ route('education.index') }}">
                    <i class="sidebar-menu-icon material-icons">help_outline</i>
                     Help
                </a>

                <a class="dropdown-item" href="{{ route('billing.card') }}">
                    <i class="sidebar-menu-icon material-icons">attach_money</i>
                     Billing
                    @if($team->status != 'active' && $team->status != 'freeze_silent')
                        <div style="background-color: red;
                         height: 10px;
                         width: 10px;
                         border-radius: 50%;
                         float: right;
                         margin-right: 114px;
                         margin-top: 3px;"></div>
                    @endif
                </a>

                <a class="dropdown-item" href="{{ route('legal') }}">
                    <i class="sidebar-menu-icon material-icons">gavel</i>
                     Legal
                </a>

                <div class="dropdown-divider"></div>

                <div class="dropdown-item">
                    <small>Theme: &nbsp;</small>



                    <a title="Dark Theme" href="{{ route('profile.preference', 'dark') }}"
                        class="theme {{ $dark ? 'theme-active' : '' }}"><i class="fa fa-square"></i></a>
                    <a title="Light Theme" href="{{ route('profile.preference', 'light') }}"
                        class="theme {{ !$dark ? 'theme-active' : '' }}"><i class="fa fa-btn fa-square-o"></i></a>
                    &nbsp;
                </div>

                <div class="dropdown-divider"></div>
                <a id="logout" class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
							document.getElementById('logout-form').submit();">
                    <i class="fa fa-lock"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>

        @endif
    </ul>
    <!-- // END Menu -->
</nav>
