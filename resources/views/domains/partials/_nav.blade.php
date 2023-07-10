<h1 class="page-heading">
    Domains
    {{ !empty($domain) ? ' - ' .$domain->domain : '' }}
</h1>
@include('fe.layouts._breadcrumbs')

@if(!empty($domain))
<ul class="nav nav-pills flex-sm-row" style="padding-bottom: 15px;">
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'domains.index' ? ' active' : ''}}" href="{{ route('domains.index') }}">
            <i class="fa fa-globe"></i>
            Domains
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ (Route::currentRouteName() == 'domains.edit' || Route::currentRouteName() == 'domains.advanced') ? ' active' : ''}}"
            href="{{ route('domains.edit', $domain->id) }}">
            <i class="fa fa-cog"></i>
            Settings
        </a>
    </li>
    {{--     
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'domains.emails.index' ? ' active' : ''}}"
            href="{{ route('domains.emails.index', $domain) }}">
            <i class="fa fa-envelope-o"></i>
            Emails
        </a>
    </li>
    --}}
    <li class="nav-item">
        <a class="nav-link{{ strpos(Route::currentRouteName(), "domains.email_boxes") !== false ? ' active' : ''}}"
        href="{{ route('domains.email_boxes.index', $domain->id) }}">
            <i class="fa fa-envelope-o"></i>
            {{-- <span class="material-icons">mail</span> --}}
            Emails
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ strpos(Route::currentRouteName(), "domains.hosting") !== false ? ' active' : ''}}"
            href="{{ route('domains.hosting.index', $domain->id) }}">
            <i class="fa fa-hdd-o"></i>
            Hosting
        </a>
    </li>
{{--
    <li class="nav-item">
        <a class="nav-link{{ strpos(Route::currentRouteName(), "domains.dns") !== false ? ' active' : ''}}"
            href="{{ route('domains.dns.index', $domain) }}">
            <i class="fa fa-server"></i>
            DNS
        </a>
    </li>
--}}
    <li class="nav-item">
        <a class="nav-link{{ strpos(Route::currentRouteName(), "domains.advanced") !== false ? ' active' : ''}}"
            href="{{ route('domains.advanced.lock', $domain->id) }}">
            <i class="fa fa-code"></i>
            Advanced
        </a>
    </li>





</ul>
@endif