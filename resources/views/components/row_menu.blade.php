<div class="btn-group {{ $btn_group_class ?? 'pull-right' }}">
    @foreach($items as $item)
        @if(!isset($item['hide']))
        <a 
            href="{{ $item['route'] }}" 
            title="{{ $item['display'] }}"
            class="btn btn-sm {{ isset($item['color']) ? $item['color'] : 'btn-default' }} {{ isset($item['link-class']) ? $item['link-class'] : ''  }}" 
            @if (isset($item['new_window'])) target="_blank" @endif
            @if (isset($item['data']) && is_array($item['data']))
                @foreach ($item['data'] as $key => $data)
                    data-{{ $key }}="{{ $data }}" 
                @endforeach
            @endif
        >
            @if(!empty($item['icon']))
            <i class="{{ $item['icon'] }}"></i>
            @endif
            @if(isset($item['force_display']) && $item['force_display'] == true )
                {{ $item['display'] }}
            @endif
        </a>
        @endif
    @endforeach
    <div class="btn-group">
        <div class="dropdown show">
            <a class="btn btn-sm btn-default dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bars"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                @foreach($items as $item)
                <a 
                    href="{{ $item['route'] }}" 
                    title="{{ $item['display'] }}"
                    class="dropdown-item {{ isset($item['link-class']) ? $item['link-class'] : ''  }}" 
                    @if(isset($item['data-link'])) data-link="{{ $item['data-link'] }}" @endif 
                    @if(isset($item['new_window'])) target="_blank" @endif
                    @if (isset($item['data']) && is_array($item['data']))
                        @foreach ($item['data'] as $key => $data)
                            data-{{ $key }}="{{ $data }}" 
                        @endforeach
                    @endif
                >   
                    @if(!empty($item['icon']))
                        <i class="{{ $item['icon'] }}"></i>
                        {{ $item['display'] }}
                    @endif
                </a>
                @endforeach

            </div>
        </div>
    </div>
</div>
