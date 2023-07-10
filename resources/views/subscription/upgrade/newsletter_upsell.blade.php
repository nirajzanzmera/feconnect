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
            <div class="card">
                <div class="card-header">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="card-title">Special Offer!</h4>
                            <p class="card-subtitle"></p>
                        </div>
                        <div class="media-right media-middle"></div>
                    </div>
                </div>
                <div class="card-block" style="text-align: center">
                    <h4>
                        GET OUR MARKETING TIPS NEWSLETTER <br />
                        & START SENDING EMAILS FOR
                    </h4>
                    <h2>
                        FREE!
                    </h2>
                </div>
                <div class="card-block">
                    <p>
                        Sign-up for our exclusive email marketing newsletter and we'll give you access to send emails
                        30 days for free! You'll also get access to all of the Dataczar features FREE for 30 days, and
                        then it's just $19.95 a month to the same card you used today. 
                        Keep in mind you can cancel at any time.
                    </p>
                    <div class="row form-group">
                        <label class="col-md-12 form-control-label" style="font-weight: bold;">
                            Get our email marketing tips newsletter:
                        </label>
                        <input name="email" type="email" class="form-control" value="{{ auth()->user()->email }}">
                    </div>
                </div>
                <div class="card-block" style="text-align: center">
                    <div class="row form-group">
                        <form action="{{ route('plans.upgrade_plan', 3) }}" method="POST" id="subscribe_form">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-success btn-lg" id="submit_btn">
                                Subscribe
                            </button> <br />
                            <a href="{{ route('plans.username') }}" class="btn">I'll sign up later</a>
                        </form>
                    </div>
                </div>
            </div>
            <div>
                <small style="color:#999">Void where prohibited. Other terms, conditions, and restrictions may apply.
                    This offer is subject to change or termination without notice. If you sign up for our newsletter
                    today, you can start sending up to 5,000 emails per month for no additional cost. Your Dataczar
                    access continues until cancelled. If you do not wish to continue for $19.95/mo you can cancel 
                    anytime at the site or by calling (844) 855-2927.</small>
            </div>
        </div>
    </div>
</div>

@endsection


@section('js')
<script>
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
</script>
@endsection
