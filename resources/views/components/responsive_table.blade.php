<div class="card-block card-block-light" style="margin: .625rem;margin-top: 0;padding: 0;">
    <ul class="list-group">
        <li class="list-group-item row hidden-lg-down row ">
            @foreach($header as $col)
                @if(isset($col['cols']))
                <div class="col-lg-{{ $col['cols'] ?? '' }}"><strong>{{ $col['label'] ?? '' }}</strong></div>
                @else
                <div class="col-lg-{{ floor(12 / count($header)) }}"><strong>{{ $col['label'] ?? '' }}</strong></div>
                @endif
            @endforeach
        </li>
        @foreach($rows as $row)
        <li class="list-group-item row">
            @foreach($header as $col)
                @if(isset($col['cols']))
                <div class="col-xl-{{ $col['cols'] ?? '' }}">
                @else
                <div class="col-xl-{{ floor(12 / count($header)) ?? '' }}">
                @endif
                    @if(!empty($col['label']))
                    <label class="hidden-xl-up">
                        <strong>{{ $col['label'] ?? '' }}:</strong>
                    </label>
                    @endif

                    @if (isset($col['raw']) && $col['raw'] == true)
                        {!! $row->{$col['field']} ?? '' !!}
                    @else
                        {{ $row->{$col['field']} ?? '' }}
                    @endif
                    
                </div>
            @endforeach
        </li>
        @endforeach
    </ul>
</div>