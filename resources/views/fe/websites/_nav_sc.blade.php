@if($headless != true)
@if($hidebreadcrumbs != true)
@include('layouts.partials._breadcrumbs')
@endif

@if($hidesubmenu != true)
<ul class="nav nav-pills flex-column flex-sm-row" style="padding-bottom: 15px;">
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
            class="nav-link{{ strpos(Route::currentRouteName(), 'shopping_cart.index') !== false ? ' active' : ''}}"
            href="{{ route('shopping_cart.index', $website) }}">
            <i class="fa fa-cog"></i>
            Settings
        </a>
    </li>
    @else
    <li class="nav-item">
        <a class="nav-link disabled">
            <i class="fa fa-cog"></i>
            Settings
        </a>
    </li>
    @endif
</ul>
@endif
@endif
