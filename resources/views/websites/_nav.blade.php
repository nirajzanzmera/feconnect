@if($headless != true)
@if($hidebreadcrumbs != true)
@include('layouts.partials._breadcrumbs')
@endif
@if($hidesubmenu != true)
<ul class="nav nav-pills flex-sm-row" style="padding-bottom: 15px;">
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'websites.index' ? ' active' : ''}}"
            href="{{ route('websites.index') }}">
            <i class="fa fa-globe"></i>
            Websites
        </a>
    </li>
    @if ( !empty($website) )
    <li class="nav-item">
        <a id="website_pages"
            class="nav-link{{ strpos(Route::currentRouteName(), 'websites.pages') !== false ? ' active' : ''}}"
            href="{{ route('websites.pages.index', $website) }}">
            <i class="fa fa-bookmark"></i>
            Pages
        </a>
    </li>
    <li class="nav-item">
        <a id="website_posts"
            class="nav-link{{ strpos(Route::currentRouteName(), 'websites.posts') !== false ? ' active' : ''}}"
            href="{{ route('websites.posts.index', $website) }}">
            <i class="fa fa-list"></i>
            Posts
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ strpos(Route::currentRouteName(), 'websites.templates') !== false ? ' active' : ''}}"
            href="{{ route('websites.templates.index', $website) }}">
            <i class="fa fa-puzzle-piece"></i>
            Templates
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'websites.theme' ? ' active' : ''}}"
            href="{{ route('websites.theme', $website) }}">
            <i class="fa fa-paint-brush"></i>
            Theme
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'websites.edit' ? ' active' : ''}}"
            href="{{ route('websites.edit', $website) }}">
            <i class="fa fa-cog"></i>
            Settings
        </a>
    </li>
    @else
    <li class="nav-item">
        <a class="nav-link disabled">
            <i class="fa fa-bookmark"></i>
            Pages
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled">
            <i class="fa fa-list"></i>
            Posts
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled">
            <i class="fa fa-puzzle-piece"></i>
            Templates
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled">
            <i class="fa fa-paint-brush"></i>
            Theme
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled">
            <i class="fa fa-cog"></i>
            Settings
        </a>
    </li>
    @endif
    <li class="nav-item">
        <a class="nav-link{{ strpos(Route::currentRouteName(), 'websites.analytics') !== false ? ' active' : ''}}"
            href="{{ !empty($website) ? route('websites.analytics', $website) : route('websites.analytics') }}">
            <i class="fa fa-bar-chart"></i>
            Analytics
        </a>
    </li>
</ul>
@endif
@if($hidesubcontext != true)
@if(!empty($websites) || !empty($website))
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            @if(!empty($websites) && $websites->count() > 1)
            <div class="dropdown">
                Website:
                <a class="dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-haspopup="true"
                    aria-expanded="false">
                    @if(!empty($website))
                    {{ $website->name }}
                    @else
                    All
                    @endif
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item{{ empty($website) ? ' active' : ''}}"
                        href="{{ route('websites.analytics', [ 'website' => null, 'sd' => $start->format('Y-m-d'), 'ed' => $end->format('Y-m-d') ]) }}">
                        All
                    </a>
                    @foreach ($websites as $site)
                    <a class="dropdown-item{{ !empty($website) && $site->id == $website->id ? ' active' : ''}}"
                        href="{{ route('websites.analytics', [ 'website' => $site, 'sd' => $start->format('Y-m-d'), 'ed' => $end->format('Y-m-d') ]) }}">
                        {{ $site->name }}
                    </a>
                    @endforeach
                </div>
            </div>
            @elseif (!empty($website))
            Website: {{ $website->name }}
            @endif
        </h2>
    </div>
    @if (!empty($website))
    <div class="card-block">
        <strong>Public Preview URL: </strong>

        @if(!empty($page))
        <a target="_blank" href="{{ !empty($page) ? $page->preview_link : $website->preview }}"
            @if($dark)style="color:white" @endif>
            {{ !empty($page) and !empty($page->preview_link) ? $page->preview_link : $website->preview }}
        </a>
        @elseif(!empty($post) && $post->status == 'live' && $post->start_time->format('Y-m-d') <= date("Y-m-d")) <a
            target="_blank" href="{{ !empty($post) ? $post->preview_link : $website->preview }}"
            @if($dark)style="color:white" @endif>
            {{ !empty($post) and !empty($post->preview_link) ? $post->preview_link : $website->preview }}
            </a>
            @else
            <a target="_blank" href="{{ $website->preview }}" @if($dark)style="color:white" @endif>
                {{ $website->preview }}
            </a>
            @endif

            |
            @if(!empty($website->domain))
            @if($website->domain->cf_status != 'Deployed')
            <strong>Website is deploying: </strong>
            <i class="fa fa-spinner fa-pulse"></i>
            @else
            <strong>Visit Website: </strong>
            @if(!empty($page))
            <a target="_blank" href="{{ !empty($page) ? $page->site_link : $website->preview }}"
                @if($dark)style="color:white" @endif>
                {{ !empty($page) ? $page->site_link : $website->preview }}
            </a>
            @else
            <a target="_blank" href="{{ $website->url }}" @if($dark)style="color:white" @endif>
                {{ $website->url }}
            </a>
            @endif
            @endif
            @else
            <strong>Domain Name: </strong>
            <a href="{{ route('domains.index') }}" @if($dark)style="color:white" @endif>Get Your Domain Name</a>
            @endif
    </div>
    @endif
</div>
@endif
@endif
@endif