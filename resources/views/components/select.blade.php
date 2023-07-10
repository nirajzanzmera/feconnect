<div class="row form-group">
    @if (isset($label))
    <label for="{{ $name }}" class="col-lg-2 text-lg-right form-control-label">{{ $label }}</label>
    @endif
    <div class="col-lg-10">
        <select id="{{ $name }}" name="{{ $name }}" class="form-control" {{ isset($attributes) ? $attributes : '' }}>
            @foreach($options as $option)
                @if( isset($object) && $object->{$name} == $option['value'] )
                    <option value="{{ $option['value'] }}" selected>{{ $option['label'] }}</option>
                @else 
                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                @endif
            @endforeach
        </select>
        @if ($errors->has($name))
        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
        @endif
    </div>
</div>

