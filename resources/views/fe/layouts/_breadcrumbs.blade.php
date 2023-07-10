<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('homebc') }}">Home</a></li>
    @foreach(request()->breadcrumbs()->segments() as $segment)
    <li class="breadcrumb-item {{ ($segment->active()) ? 'active' : '' }}">
        @if($segment->active())
        {{ optional($segment->model())->breadName ?: $segment->name() }}
        @else
        <a href="{{ $segment->url() }}">
            {{ optional($segment->model())->breadName ?: $segment->name() }}
        </a>
        @endif
    </li>
    @endforeach
</ol>