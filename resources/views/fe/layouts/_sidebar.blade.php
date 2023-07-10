<div class="{!! session('sidebar') == 'collapsed' ? 'collapsed' : '' !!} sidebar sidebar-left si-si-3 sidebar-visible-md-up sidebar-dark ls-top-navbar-md-up hidden-print"
    id="sidebarLeft">

    @if( !empty($team->name) && count($teams) > 1) {{--->wherePivot('menu_suppression',0)->get()->count() > 1 )--}}
    <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
        <div class="sidebar-heading">Switch Accounts</div>
        <ul class="sidebar-menu sm-bordered sm-active-button-bg">
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button" href="#">
                    <i class="sidebar-menu-icon material-icons">people</i> {{ $team->name }}
                </a>
                <ul class="sidebar-submenu">
                    @foreach ($teams as $thisteam)
                    @if( !empty($thisteam->pivot) && $thisteam->pivot->menu_suppression == 0 )
                    <li class="sidebar-menu-item">
                        <a class="sidebar-menu-button" href="{{ route('teams.switch', ['id' => $thisteam->account_id ]) }}">
                            {!! ($thisteam->account_id == $team->id ) ? '&middot;' : '' !!}
                            {{ $thisteam->account_name }}
                            {!! ($thisteam->account_id == $team->id ) ? '&middot;' : '' !!} 
                        </a>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </li>
        </ul>
    </span>
    @endif


    <div class="sidebar-heading">
        <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
            Main
        </span>
        Menu
    </div>
    <ul class="sidebar-menu sm-bordered sm-active-button-bg">
{{--
        @if( auth()->user()->blasts->count() > 0 )
        <li class="sidebar-menu-item{{ strpos(Route::currentRouteName(), 'share') !== false ? ' active' : ''}}">
            <a class="sidebar-menu-button" href="{{ route('share.index') }}" title="Shared with Me">
                <i class="sidebar-menu-icon material-icons">share</i>
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    Shared with Me
                </span>
            </a>
        </li>
        @endif
        @if(Auth::user()->admin == true)
        <li class="sidebar-menu-item{{ strpos(Route::currentRouteName(), 'admin') !== false ? ' active' : '' }}">
            <a class="sidebar-menu-button" href="{{ route('admin.index') }}" title="Admin">
                <i class="sidebar-menu-icon material-icons">dashboard</i>
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    Admin
                </span>
            </a>
        </li>
        @elseif(Auth::user()->has_cs_basic)
        <li class="sidebar-menu-item{{ strpos(Route::currentRouteName(), 'admin') !== false ? ' active' : '' }}">
            <a id="cs_admin" class="sidebar-menu-button" href="{{ route('admin.cs_index') }}" title="CS Admin">
                <i class="sidebar-menu-icon material-icons">dashboard</i>
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    CS Admin
                </span>
            </a>
        </li>
        @endif
        @if(!Auth::user()->is_cs_basic || empty(session('currentTeam')))
--}}
        <li class="sidebar-menu-item{{ (Route::currentRouteName() == 'home') ? ' active' : ''}}">
            <a class="sidebar-menu-button" href="{{ route('home') }}" title="Dashboard">
                <i class="sidebar-menu-icon material-icons">home</i> 
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    Dashboard
                </span>
            </a>
        </li>
        <li class="sidebar-menu-item{{ strpos(Route::current()->uri, 'websites') === 0 ? ' active' : ''}}">

            <a class="sidebar-menu-button" href="{{ route('websites.dashboard') }}" title="Websites">
                <i class="sidebar-menu-icon material-icons">web</i> 
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    Website
                </span>
            </a>
        </li>
        <li class="sidebar-menu-item{{ strpos(Route::current()->uri, 'emails') !== false ? ' active' : ''}}">
            <a class="sidebar-menu-button" href="{{ route('reports.dashboard') }}" title="Emails">
                <i class="sidebar-menu-icon material-icons">mail</i> 
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    Emails
                </span>
            </a>
        </li>
        <li class="sidebar-menu-item{{ strpos(Route::currentRouteName(), 'lists') !== false ? ' active' : ''}}">
            @if ( !empty($defaultListId) )
            <a class="sidebar-menu-button" href="{{ route('lists.subscribers', ['list'=>$defaultListId]) }}"
                title="Lists">
                <i class="sidebar-menu-icon material-icons">list</i> 
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    Lists
                </span>
            </a>
            @else
            <a class="sidebar-menu-button" href="{{ route('lists.index') }}" title="Lists">
                <i class="sidebar-menu-icon material-icons">list</i> 
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    Lists
                </span>
            </a>
            @endif
        </li>
        <li class="sidebar-menu-item{{ strpos(Route::current()->uri, 'domains') !== false ? ' active' : ''}}">
            <a class="sidebar-menu-button" href="{{ route('domains.index') }}" title="Domains">
                <i class="sidebar-menu-icon material-icons">public</i> 
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    Domains
                </span>
            </a>
        </li>
        <li class="sidebar-menu-item{{ strpos(Route::current()->uri, 'content') !== false ? ' active' : ''}}">
            <a class="sidebar-menu-button" href="{{ route('content.images') }}" title="Content">
                <i class="sidebar-menu-icon material-icons">photo</i> 
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    Content
                </span>
            </a>
        </li>
        {{-- <li class="sidebar-menu-item{{ strpos(Route::current()->uri, 'automation') !== false ? ' active' : ''}}">
            <a class="sidebar-menu-button" href="{{ route('newsletters.index') }}" title="Automation">
                <i class="sidebar-menu-icon material-icons">event</i> 
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    Automation
                </span>
            </a>
        </li>--}}

        {{-- <li class="sidebar-menu-item{{ (Route::currentRouteName() == 'templates.index') || (Route::currentRouteName() == ('templates.newsletter')) ? ' active' : ''}}">
            <a class="sidebar-menu-button" href="{{ route('templates.index') }}" title="Templates">
                <i class="sidebar-menu-icon material-icons">extension</i> 
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    Templates
                </span>
            </a>
        </li> --}}

    </ul>

    <div class="hidden-md-up sidebar-heading">
        <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
            Settings
        </span>
    </div>

    <ul class="sidebar-menu sm-bordered sm-active-button-bg">

        <li class="hidden-md-up sidebar-menu-item{{ (strpos(Route::current()->uri, 'user') !== false or strpos(Route::current()->uri, 'accounts') !== false ) ? ' active' : ''}}">
            <a class="sidebar-menu-button" href="{{ route('user.dashboard') }}" title="Profile">
                <i class="sidebar-menu-icon material-icons">account_box</i> 
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    Profile
                </span>
            </a>
        </li>
        <li class="hidden-md-up sidebar-menu-item{{ strpos(Route::current()->uri, 'education') !== false ? ' active' : ''}}">
            <a class="sidebar-menu-button" href="{{ route('education.index') }}" title="Education">
                <i class="sidebar-menu-icon material-icons">help_outline</i> 
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    Help
                </span>
            </a>
        </li>

        {{-- <li class="hidden-md-up sidebar-menu-item{{ (Route::currentRouteName() == 'senders.index') ? ' active' : ''}}">
            <a class="sidebar-menu-button" href="{{ route('senders.index') }}" title="Settings">
                <i class="sidebar-menu-icon material-icons">settings</i> 
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' 
                : 
                '' !!}">Settings
                    @if(Auth::user()->currentTeam->senders->count()< 1) <i class="fa fa-warning pull-right"
                        style="padding: 15px;"></i>
                        @endif
                </span>
            </a>
        </li> --}}
        
        <li class="hidden-md-up sidebar-menu-item{{ (Route::currentRouteName() == 'billing.card') ? ' active' : ''}}">
            <a class="sidebar-menu-button" href="{{ route('billing.card') }}"
                title="Billing">
                <i class="sidebar-menu-icon material-icons">attach_money</i> 
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    Billing
                    @if($team->status != 'active' && $team->status != 'freeze_silent')
                    <i class="fa fa-warning pull-right" style="padding: 15px;"></i>
                    @endif
                </span>
            </a>
        </li>

        <li class="hidden-md-up sidebar-menu-item{{ (Route::currentRouteName() == 'legal') ? ' active' : ''}}">
            <a class="sidebar-menu-button" href="{{ route('legal') }}" title="Legal">
                <i class="sidebar-menu-icon material-icons">gavel</i>
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    Legal
                </span>
            </a>
        </li>

        <li class="sidebar-menu-item hidden-md-up">
            <a class="sidebar-menu-button" href="{{ route('logout') }}" title="logout" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="sidebar-menu-icon material-icons">lock</i>
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    Logout
                </span>
            </a>
        </li>
        <li class="sidebar-menu-item hidden-sm-down">
            <a class="sidebar-menu-button toggleSideBar" href="#" title="Collapse">
                <i class="sidebar-menu-icon material-icons toggle-icon">chevron_left</i> 
                <span class="side-bar-label {!! session('sidebar') == 'collapsed' ? 'hide' : '' !!}">
                    Collapse
                </span>
            </a>
        </li>
    </ul>
{{--@endif--}}
</div>
<!-- END MENU -->
