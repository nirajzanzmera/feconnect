@if(($quicklinks['quicklink_cnt'] ?? 0) > 0)
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                Quick Links {{--$quicklinks['quicklink_cnt']--}}
            </h4>
        </div>
        <div class="list-group">
            @foreach(json_decode(json_encode($quicklinks['quicklinks']),true) as $key => $link)
            <a class="list-group-item" id="{{ $key }}_link" href="{{ $link['url'] ?? ''}}" @if(isset($link['window'])) target="_blank" @endif>
                <div class="media">
                    <div class="media-left">
                        <i class="fa {{ $link['fa'] ?? '' }}"></i>
                    </div>
                    <div class="media-body media-middle">
                        {{ $link['text'] ?? '' }}
                    </div>
                    <div class="media-right">
                        <i class="fa fa-chevron-right"></i>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
@endif
