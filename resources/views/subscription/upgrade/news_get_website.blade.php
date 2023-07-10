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
Get our Marketing Tips Newsletter <br />
&amp; Get your .com Website for 
                    </h4>
                    <h2>
                        FREE!
                    </h2>
                </div>
                <div class="card-block">
                    <p>
                        Sign-up for our exclusive email marketing newsletter and we’ll give you a 
                        domain name and website 30 days for free! You’ll also get access to all of 
                        the Dataczar features FREE for 30 days, and then it’s just $9.95 a month to 
                        the same card you used today. Keep in mind you can cancel at any time.
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
                        <form action="{{ route('plans.upgrade_plan', 2) }}" method="POST">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-success btn-lg">
                                Subscribe
                            </button> <br />
                            <a href="{{ route('auth.phone_confirmation') }}" class="btn">I'll sign up later</a>
                        </form>
                    </div>
                </div>
            </div>
            <div>
                <small style="color:#999">Void where prohibited. Other terms, conditions, and restrictions may apply.
                    This offer is subject to change or termination without notice. If you sign up for our newsletter
                    today, you can start sending up to 2,000 emails per month for no additional cost. Your Dataczar
                    access continues until cancelled. If you do not wish to continue for $9.95/mo you can cancel
                    anytime at the site or by calling (844) 855-2927.</small>
            </div>
        </div>
    </div>
</div>

@endsection


@section('js')

@endsection