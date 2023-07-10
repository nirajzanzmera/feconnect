{{--@if($headless != true)--}}
{{--@if($hidetitle != true)--}}
<div>
    <h1 class="page-heading">Education</h1>
</div>

<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>

    @if(isset($menu))
        <li class="breadcrumb-item"><a href="{{ url('education') }}">Education</a></li>
        <li class="breadcrumb-item @if(isset($menu)) active @endif ">{{ $menu }}</li>
    @else
        <li class="breadcrumb-item active ">Education</li>
    @endif
</ol>
{{--@endif--}}
{{--@if($hidebreadcrumbs != true)--}}
{{--@include('fe.layouts._breadcrumbs')--}}
{{--@endif--}}
{{--@if($headless != true)--}}
<ul class="nav nav-pills flex-sm-row" style="padding-bottom: 15px;">
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'education.index' ? ' active' : ''}}"
            href="{{ route('education.index') }}">
            <i class="fa fa-question-circle"></i>
            Help
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'education.getting_started' ? ' active' : ''}}"
            href="{{ route('education.getting_started') }}">
            <i class="fa fa-map-o"></i>
            Getting Started
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'education.videos' ? ' active' : ''}}" 
            href="{{ route('education.videos') }}">
            <i class="fa fa-video-camera"></i>
            Videos
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'education.ebooks' ? ' active' : ''}}" 
            href="{{ route('education.ebooks') }}">
            <i class="fa fa-book"></i>
            eBooks
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'education.coaching' ? ' active' : ''}}" 
            href="{{ route('education.coaching') }}">
            <i class="fa fa-briefcase"></i>
            Business Coaching
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link{{ Route::currentRouteName() == 'education.ask' ? ' active' : ''}}"
            href="{{ route('education.ask') }}">
            <i class="fa fa-question"></i>
            Ask
        </a>
    </li>
</ul>
{{--@endif--}}
{{--@endif--}}