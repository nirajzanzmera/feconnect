<div class="row form-group">
    @if (isset($label))
    <label for="{{ $name }}" class="col-lg-2 text-lg-right form-control-label">{{ $label }}</label>
    @endif
    <div class="col-lg-10">
        <input id="{{ $name }}" 
            type="{{ isset($type) ? $type : 'text' }}"
            class="form-control"
            name="{{ $name }}"
            placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
            value="{{
                old($name) ?: (isset($object) ? $object->{$name} : '')
            }}"
            {{ isset($attributes) ? $attributes : '' }}
        >
        @if ($errors->has($name))
        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
        @endif
    </div>
</div>

