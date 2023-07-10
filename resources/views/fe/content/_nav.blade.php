
<div>
    <h1 class="page-heading">Content</h1>
</div>
@include('fe.layouts._breadcrumbs')
<ul class="nav nav-pills flex-sm-row" style="padding-bottom: 15px;">
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'content.index' ? ' active' : ''}}"
            href="{{ route('content.index') }}">
            <i class="fa fa-upload"></i>
            Upload
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'content.images' ? ' active' : ''}}"
            href="{{ route('content.images') }}">
            <i class="fa fa-image"></i>
            My Images
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'content.files' ? ' active' : ''}}" 
            href="{{ route('content.files') }}">
            <i class="fa fa-file"></i>
            My Files
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'content.search' ? ' active' : ''}}" 
            href="{{ route('content.search') }}">
            <i class="fa fa-search"></i>
            Free Images
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'content.icons' ? ' active' : ''}}"
           href="{{ route('content.icons') }}">
            <i class="fa fa-search-plus"></i>
            Icons
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ strpos(Route::currentRouteName(), 'feeds') !== false ? ' active' : ''}}"
            href="{{ route('content.feeds.index') }}">
            <i class="fa fa-rss"></i>
            Feeds
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'content.tools' ? ' active' : ''}}" 
            href="{{ route('content.tools') }}">
            <i class="fa fa-briefcase"></i>
            Content Tools
        </a>
    </li>
</ul>
