@if(!isset($headless) || (isset($headless) && $headless != true))
@if(!isset($hidesubmenu) || (isset($hidesubmenu) && $hidesubmenu != true))
<ul class="nav nav-pills flex-sm-row" style="padding-bottom: 15px;">
    <li class="nav-item">
        <a class="nav-link{{ (Route::currentRouteName() == 'lists.index') ? ' active' : ''}}"
            href="{{ route('lists.index') }}">
            <span class="material-icons">list</span>
            Lists
        </a>
    </li>
    @if(Route::currentRouteName() != 'lists.index' )
    <li class="nav-item">
        <a class="nav-link{{ (Route::currentRouteName() == 'lists.subscribers') ? ' active' : ''}}"
            href="{{ route('lists.subscribers',$list->id) }}">
            <span class="material-icons">people</span>
            Subscribers
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ (Route::currentRouteName() == 'lists.upload') ? ' active' : ''}}"
            href="{{ route('lists.upload',$list->id) }}">
            <span class="material-icons">cloud_upload</span>
            Upload
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ (Route::currentRouteName() == 'lists.settings') ? ' active' : ''}}"
            href="{{ route('lists.settings',$list->id) }}">
            <span class="material-icons">settings</span>
            Settings
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ (Route::currentRouteName() == 'lists.analytics') ? ' active' : ''}}"
            href="{{ route('lists.analytics',$list->id) }}">
            <span class="material-icons">insert_chart</span>
            Analytics
        </a>
    </li>
    @else
    <li class="nav-item"  title="Please Manage a list below">
        <a class="nav-link disabled">
            <span class="material-icons">people</span>
            Subscribers
        </a>
    </li>
    <li class="nav-item"  title="Please Manage a list below">
        <a class="nav-link disabled">
            <span class="material-icons">cloud_upload</span>
            Upload
        </a>
    </li>

    <li class="nav-item"  title="Please Manage a list below">
        <a class="nav-link disabled">
            <span class="material-icons">settings</span>
            Settings
        </a>
    </li>
    <li class="nav-item"  title="Please Manage a list below">
        <a class="nav-link disabled">
            <span class="material-icons">insert_chart</span>
            Analytics
        </a>
    </li>


    @endif
</ul>
@endif
@endif