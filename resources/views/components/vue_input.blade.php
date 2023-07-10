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
            @if(isset($model))
                v-model="{{ $model }}" 
            @endif
            @if(isset($model_error))
                v-bind:class="{ 'is-invalid': {{ $model_error ?? '' }} }" 
            @endif           
            
            @php
            if(str_replace($namespace.'.','', $model) == 'email' && $namespace == 'editing.form') {
                echo " :disabled=\"editing.form.status == 'active' ? true : false\"";
            }
            @endphp
        >

        @php
            if(isset($model_error)) {
                echo "
                <div class=\"invalid-feedback\" v-if=\"".($model_error ?? '')."\">
                    {{ " . ($model_error ?? '') . "[0] }}
                </div>";
            }
        @endphp
    </div>
</div>
