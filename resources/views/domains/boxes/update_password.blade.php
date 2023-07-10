@extends('layouts.app')
@section('content')

@include('domains.partials._nav')

<div class="row-fluid">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title pull-left">Email Box: {{ $emailBox->email }} </h4>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <legend>Email Box</legend>
                <form action="{{ route('domains.email_boxes.update_password', ['domain' => $domain, 'emailBox' => $emailBox]) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <fieldset class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password">Password</label>
                        <input name="password" type="password" class="form-control pass" value="" autocomplete="new-password" id="pass1">
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </fieldset>

                    <fieldset class="form-group{{ $errors->has('password2') ? ' has-error' : '' }}">
                        <label for="password2" id="pass2_label">Confirm Password</label>
                        <input name="password2" type="password" class="form-control pass" value="" id="pass2">
                        @if ($errors->has('password2'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password2') }}</strong>
                        </span>
                        @endif
                    </fieldset>

                    <button class="btn btn-success" id="update_btn">
                        <i class="fa fa-save"></i>
                        Update Password
                    </button>
                </form>

                <hr>
                


            </div>
        </div>
    </div>
</div>
</div>

</div>
@endsection
@section('js')

<script>
    $(document).ready(function(){
        $('.pass').on('keyup', function(e){
            if( $('#pass1').val() != $('#pass2').val()  ) {
                $('#pass2_label').addClass('text-danger');
                $("#update_btn").attr("disabled", true);
            } else {
                $('#pass2_label').removeClass('text-danger');
                $("#update_btn").attr("disabled", false);
            }
        })
    });
</script>

@endsection