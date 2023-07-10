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
                            <h4 class="card-title">Username</h4>
                            <p class="card-subtitle"></p>
                        </div>
                        <div class="media-right media-middle"></div>
                    </div>
                </div>
                <div class="card-block" style="text-align: center">
                    <h4>
                        Please choose a business name for your account that will help your customers find
                        you:
                    </h4>
                </div>
                <form action="{{ route('plans.username') }}" method="POST">
                    <div class="card-block">
                        <div class="row form-group">
                            <label class="col-md-12 form-control-label" style="font-weight: bold;">
                                Your Business:
                            </label>
                            <input name="username" id="username" type="text" class="form-control" value="" placeholder="" required>
                        </div>
                    </div>
                    <div class="card-block" style="text-align: center">
                        <div class="row">
                            <h4>Your website could be: <span id="domain"></span></h4>
                        </div>
                    </div>
                    <div class="card-block" style="text-align: center">
                        <div class="row form-group">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-success btn-lg">
                                Submit
                            </button>
                            <br />
                            <a href="{{ route('auth.phone_confirmation') }}" class="btn">I'll do this later</a>
                        </div>
                    </div>
                </form>
            </div>
            <div>
                <small style="color:#999"></small>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#username').on('input blur keyup paste', function () {
            var username = $(this).val() + "";
            username = username.replace(/[^a-z0-9-]/ig, '').toLowerCase() + '.com';
            $('#domain').html(username);
        });
    });
</script>

<img src="https://www.shareasale.com/sale.cfm?tracking={{ auth()->user()->currentTeam->id }}&amount=9.95&merchantID=97999&transtype=sale"
    width="1" height="1">
<script src="https://www.dwin1.com/19038.js" type="text/javascript" defer="defer"></script>
@endsection