@extends('fe.layouts.app')
@section('content')
<style>
    .media-icon {
        margin-left: .5rem !important;
        margin-right: .5rem !important;
        padding: 1rem !important;
        position: relative;
    }
    .border-orange {
        border: 2px solid orange !important;
        height: fit-content;
    }
    .rounded-circle {
        border-radius: 50% !important;
    }
    .progress {
        display: -ms-flexbox;
        display: flex;
        height: 1rem;
        overflow: hidden;
        font-size: .75rem;
        background-color: #5e1616;
        border-radius: .25rem;
    }
    .progress-bar {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        -ms-flex-pack: center;
        justify-content: center;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        background-color: #007bff;
        transition: width .6s ease;
    }
    .media-icon .lock {
        opacity: 0.6;
        font-size: 3em;
    }
    .media-icon .fa-lock {
        position: absolute;
        left: 28px;
        transform: rotateZ(30deg);
        font-size: 2.6em;
    }
    .bg-danger {
        background-color: #E53935 !important;
    }
</style>
        <div>
            <h1 class="page-heading"> User Dashboard - {{$g_user->name}}</h1>
        </div>

        @include('fe.teamwork._nav')

<div class="row-fluid">
    @if($filter != 'password')
        <div class="col-lg-6">
            @if($filter == '' or $filter == 'user')
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">User Profile</h4>
                    </div>
                    <div class="card-block">

                        <ul class="list-unstyled lead">
                            <li><strong><i class="material-icons text-muted-light">person</i> </strong> {{ $user['name'] }}</li>
                            <li><strong><i class="material-icons text-muted-light">mail</i> </strong> {{ $user['email'] }}</li>
                            <li><strong><i class="material-icons text-muted-light" title="Member since">event</i> </strong> {{ date('m-d-Y',strtotime($user['created_at'])) }}</li>
                            <li><strong><i class="material-icons text-muted-light">phone</i> </strong> {{ $user['phone'] }}</li>
                        </ul>
                    </div>
                </div>
            @endif
            @if($filter == '' or $filter == 'notifications')
                @if ( count($user['mail_lists']) > 0 )
                    <div class="card">
                        <div class="card-header">
                            <div class="media">
                                <div class="media-body">
                                    <h4 class="card-title">Notification Settings</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach ($user['mail_lists'] as $mail_list)
                                {{ $mail_list->name }}
                                <span width="50px;" id="{{ $mail_list->id }}_status" class="label label-success"></span>
                                <br />
                                @if($mail_list->id != 6)
                                    Web :  <input type="checkbox"
                                                  data-mail_list_id="{{ $mail_list->id }}"
                                                  data-property="notification"
                                                  class="mailList_check" {{ !empty($mail_list->pivot->notification) ? ' checked': ''}}>
                                    <br />
                                @endif
                                Email : <input type="checkbox"
                                               data-mail_list_id="{{ $mail_list->id }}"
                                               data-property="email"
                                               class="mailList_check" {{ !empty($mail_list->pivot->email) ? ' checked': ''}}>
                                <br />

                                @if($mail_list->id == 2 || $mail_list->id == 3 || $mail_list->id == 5)
                                    SMS (text): <input type="checkbox"
                                                       data-mail_list_id="{{ $mail_list->id }}"
                                                       data-property="sms"
                                                       class="mailList_check" {{ !empty($mail_list->pivot->sms) ? ' checked': ''}}>

                                    <br />
                                    App: <input type="checkbox" data-mail_list_id="{{ $mail_list->id }}" data-property="push" class="mailList_check" {{
                        !empty($mail_list->pivot->push) ? ' checked': ''}}>
                                    <br />

                                @endif

                                <hr>
                            @endforeach
                        </div>
                    </div>
                @endif

            @endif

        </div>
    @endif
    @if($filter=='' or $filter=='password')
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="card-title">Change your password</h4>
                            <p class="card-subtitle"></p>
                        </div>
                        <div class="media-right media-middle">

                        </div>
                    </div>
                </div>
                <div class="card-block">

                    <form method="POST" action="{{ route('user.pass.update') }}">
                        {{ csrf_field() }} {{ method_field('PUT') }}

                        <div class="row form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-lg-6">
                                <input id="password" type="password" class="form-control" name="password" required> @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span> @endif
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-lg-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>                            @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span> @endif
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>




                </div>

            </div> {{-- end change pass card--}}

        </div>
    @endif
</div>

@endsection

@section('js')
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.standalone.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var id = 1;

            $('.mailList_check').on('change', function(e) {
                var mail_list_id = $(this).data('mail_list_id');
                var property = $(this).data('property');
                var checked = $(this).prop('checked');
                $('#'+mail_list_id+'_status').html('');
                $.ajax({
                    url: '{{ route('user.notifications') }}',
                    data: {
                        "mail_list_id": mail_list_id,
                        "property": property,
                        "value": checked
                    },
                    type: 'POST',
                    success: function(result) {
                        $('#'+mail_list_id+'_status').html('saved');
                    }
                });
            });

        });
    </script>
@endsection