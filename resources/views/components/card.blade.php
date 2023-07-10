<div 
    class="card" 
    @if(!empty($card_id)) id="{{$card_id}}" @endif
>
    @if (!empty($title) || !empty($button))
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ $title ?? '' }}</h4>
            {!! $button ?? '' !!}
        </div>
    </div>
    @endif

    {!! $slot !!}

</div>