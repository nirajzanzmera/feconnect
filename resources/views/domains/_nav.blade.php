@if(!isset($headless) || (isset($headless) && $headless != true))
<h1 class="page-heading">
    Domains
    @if(count($teams) > 1)
    - {{ $team->name }}
    @endif
</h1>
@include('fe.layouts._breadcrumbs')

@if(!isset($hidesubmenu) || (isset($hidesubmenu) && $hidesubmenu != true))
@if(!empty($domain))
<ul class="nav nav-pills flex-sm-row" style="padding-bottom: 15px;">
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'domains.index' ? ' active' : ''}}"
            href="{{ route('domains.index') }}">
            <i class="fa fa-globe"></i>
            {{ !empty($domains) && count($domains) == 1 ? $domain->domain : 'Domains' }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ (Route::currentRouteName() == 'domains.edit' || Route::currentRouteName() == 'domains.advanced') ? ' active' : ''}}"
            href="{{ route('domains.edit', $domain->id) }}">
            <i class="fa fa-cog"></i>
            Settings
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'domains.emails.index' ? ' active' : ''}}"
            href="{{ route('domains.emails.index', $domain->id) }}">
            <span class="material-icons">mail</span>
            Email Forwarding
        </a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'domains.urls.index' ? ' active' : ''}}"
    href="{{ route('domains.urls.index', $domain->id) }}">
    <span class="material-icons">link</span>
    Domain Forwarding
    </a>
    </li> --}}
    @if(strpos(Route::currentRouteName(), "domains.email_boxes") !== false)
    <li class="nav-item">
        <a class="nav-link{{ strpos(Route::currentRouteName(), "domains.email_boxes") !== false ? ' active' : ''}}"
            href="{{ route('domains.email_boxes.index', $domain->id) }}">
            <span class="material-icons">mail</span>
            Email Box
        </a>
    </li>
    @endif

</ul>
@endif
@endif
@endif