@foreach(['email','from_name'] as $field)
@component('components.vue_input', [
        'name'=> $field,
        'label' => ucwords(str_replace('_', ' ', $field)),
        'model' => $namespace . '.' . $field,
        'model_error' => $error_namespace . '.errors.' . $field,
        'attributes' => ' required',
        'type' => $field == 'email' ? 'email' : 'text',
        'namespace' => $namespace,
    ])
    @endcomponent
@endforeach

<div class="row form-group">
    <div class="col-md-offset-2 col-md-8">
        <span class="help-block">
            <i>Commercial emails are required to include your contact information including a physical address.</i>
        </span>
    </div>
</div>
@foreach(['address', 'address_2', 'city', 'state', 'zip', 'country'] as $field)
    @component('components.vue_input', [
        'name'=> $field,
        'label' => ucwords(str_replace('_', ' ', $field)),
        'model' => $namespace . '.'.$field,
        'model_error' => $error_namespace . '.errors.'.$field,
        'attributes' => ' required',
        'namespace' => $namespace,
    ])
    @endcomponent
@endforeach
