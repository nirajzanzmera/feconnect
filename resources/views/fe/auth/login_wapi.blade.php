@extends('fe.layouts.guest')

@section('css')
<meta http-equiv="cache-control" content="max-age=0">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="-1">
<meta http-equiv="expires" content="Tue, 01 Jan 1980 11:00:00 GMT">
<meta http-equiv="pragma" content="no-cache">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="padding-top:70px;">
                <h2 class="text-primary center m-a-2">
                    <a href="https://www.dataczar.com/" target="_blank">
                        <img width="250px;" src="{{ asset('img/dataczar-logo.png') }}">
                    </a>
                </h2>
                    <div class="card">
                        <div class="card-block">

                            <form  method="POST" action="{{ route('login_wapi') }}">
                                {{ csrf_field() }}

                                <div class="row form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 form-control-label">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 form-control-label">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember" checked> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    
                                    <div class="center">
                                        <button type="submit" class="btn btn-primary">Login</button>

                                        <br />


                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            Forgot Your Password?
                                        </a>
                                       
                                    </div>

                                </div>
                            </form>

                            <hr>

                            <div class="center">
                                <p class="text-muted">Access your account / Or sign up</p>
                                <a href="{{ route('register') }}" class="btn btn-primary">
                                    <i class="material-icons">mail_outline</i>
                                    Register with Email
                                </a>
                                Or
                                <a href="{{ url('/login/google') }}" class=""><img src="{{ asset('img/btn_google_signin_dark_normal_web.png') }}"></a>
                            </div>

                        </div>
                    </div>

        </div>
    </div>
</div>
@endsection
