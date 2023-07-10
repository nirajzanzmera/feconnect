@include('layouts.partials._breadcrumbs')
@if($hidesubmenu != true)
<ul class="nav nav-pills flex-sm-row" style="padding-bottom: 15px;">
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'teams.index' ? ' active' : ''}}" href="{{ route('teams.index') }}">
            <i class="fa fa-globe"></i>
            Accounts
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ strpos(Route::currentRouteName(), 'user.profile') !== false ? ' active' : ''}}" href="{{ route('user.profile') }}">
            <i class="fa fa-edit"></i>
            User Profile
        </a>
    </li>
</ul>
@endif