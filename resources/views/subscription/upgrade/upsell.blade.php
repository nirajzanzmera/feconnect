@extends('layouts.guest')
@section('content')

@if($errors->count() > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="padding-top:70px;">
            <h2 class="text-primary center m-a-2">
                <img width="250px;" src="{{ asset('img/dataczar-logo.png') }}">
            </h2>
            <div class="card">
                <div class="card-header center">
                    <strong>Checkout</strong>
                </div>
            </div>

            {!! $guts ?? 'no guts' !!}

        </div>
    </div>
</div>

@endsection


@section('js')
<script>
$(document).ready(function(){
    $(document).on('click', 'input[type=image]', function(e){
        e.preventDefault();
        $(this).attr("disabled", "disabled")
        $('#upsell_form').submit();
    });
});
</script>
{{-- <script>
$(document).ready(function(){
    $(document).on('click', '#submit_btn', function(e){ 
        e.preventDefault();
        $(this).attr("disabled", "disabled")
        dz('event', 'subscribe', '{!! json_encode($tracking) !!}');
        fbq('track', 'Subscribe', { value: 19.95, currency: 'USD' });
        $('#subscribe_form').submit();
    });
    /*  onsubmit="" */
});
</script> --}}
@endsection
