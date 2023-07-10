@include('fe.layouts._breadcrumbs')

<ul class="nav nav-pills flex-sm-row" style="padding-bottom: 15px;">
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'user.dashboard' ? ' active' : ''}}" href="{{ route('user.dashboard') }}">
            <i class="fa fa fa-tachometer"></i>
            Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'user.profile' ?  ' active' : ''}}" href="{{ route('user.profile') }}">
            <i class="fa fa-user"></i>
            Profile
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'user.journal' ?  ' active' : ''}}" href="{{ route('user.journal') }}">
            <i class="fa fa-circle"></i>
            Journal
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'profile' ?  ' active' : ''}}" href="{{ route('profile') }}">
            <i class="fa fa-cog"></i>
            Settings
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'teams.index' ? ' active' : ''}}" href="{{ route('teams.index') }}">
            <i class="fa fa-users"></i>
            Accounts
        </a>
    </li>
</ul>
