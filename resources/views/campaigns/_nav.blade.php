@include('fe.layouts._breadcrumbs')
{{-- @if($headless != true and $hidenav != true) --}}
<ul class="nav nav-pills flex-sm-row" style="padding-bottom: 15px;">
    <li class="nav-item">
        <a class="nav-link{{ (Route::currentRouteName() == 'reports.dashboard') ? ' active' : ''}}"
            href="{{ route('reports.dashboard') }}">
            <i class="fa fa-envelope"></i>
            Dashboard
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link{{ (Route::currentRouteName() == 'campaigns.index') ? ' active' : ''}}"
            href="{{ route('campaigns.index') }}">
            <i class="fa fa-envelope"></i>
            Email Blasts
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ strpos(Route::currentRouteName(), 'emails.templates') !== false ? ' active' : ''}}"
            href="{{ route('emails.templates.index') }}">
            <i class="fa fa-clone"></i>
            Templates
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ strpos(Route::currentRouteName(), 'newsletters') !== false ? ' active' : ''}}"
            href="{{ route('newsletters.index') }}">
            <span class="material-icons">note</span>
            Newsletters
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ (Route::currentRouteName() == 'senders.index') ? ' active' : ''}}"
            href="{{ route('senders.index') }}">
            <i class="fa fa-gear"></i>
            Settings
        </a>
    </li>
    <li class="nav-item">
            <a class="nav-link{{ (Route::currentRouteName() == 'reports.overview') ? ' active' : ''}}"
                href="{{ route('reports.overview') }}">
                <i class="fa fa-bar-chart"></i>
                Analytics
            </a>
        </li>
</ul>
{{-- @endif --}}