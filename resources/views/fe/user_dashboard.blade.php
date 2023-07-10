@extends('fe.layouts.app')
@section('content')
<style>
    .avatar {
        vertical-align: middle;
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
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


        <div id="app" class="row">
            <div class="col-md-12">
                <div class="card-block text-center">
                    <div class="col-sm-12">
                        <img class="avatar" src="{{$avatar}}" alt="user image">
                        <form action="{{route('save.user_image')}}" method="POST" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div class="row justify-content-center align-items-center">
                                <fieldset class="col-sm-6 text-center">
                                    <standalone v-on:standalone="standalone" v-on:close="showFile = false;" name="image"
                                        image="{{ !empty($avatar) ? $avatar : NULL }}"
                                        @if(isset($type) && $type=='icons')
                                            icon_url="{{ route('content.flaticon.search') }}"
                                        @endif 
                                        search_url="{{ route('content.images.search') }}"
                                        downup_url="{{ route('content.downUp') }}"
                                        imagelist_url="{{ route('content.images.list') }}"
                                        filelist_url="{{ route('content.images.list', ['show_files'=>true]) }}"
                                        event_url="{{ route('images.event') }}" folder="{{ $folder }}" sig="{{ $sig }}"
                                        default_search="{{ !empty($defaultSearch) ? $defaultSearch : '' }}"
                                        icon="icon"
                                        >
                                    </standalone>
                                    <button id="saveAvatar" type="submit" class="btn btn-success">
                                        Save
                                    </button>
                                </fieldset>
                            </div>
                        </form>

                    <div class="row justify-content-center">
                        <p class="col-6 text-right">Nickname:</p>
                        <p class="col-6 text-left">{{$g_user->name}}</p>
                    </div>
                    <div class="row justify-content-center">
                        <p class="col-6 text-right">Created:</p>
                        <p class="col-6 text-left">
                            <?php
                            $createdAt = \Carbon\Carbon::parse($website->created_at);
                            ?>
                            {{ $createdAt->format('d/m/Y'); }}</p>
                    </div>
                    <div class="row justify-content-center">
                        <p class="col-6 text-right">Email Verified:</p>
                        <p class="col-6 text-left">
                            @if($g_user->email_confirmed == 1)
                                <i class="fa fa-check-circle-o text-success fa-2x" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-times-circle-o text-danger fa-2x" aria-hidden="true"></i>
                                (verify)
                            @endif
                        </p>
                    </div>
                    <div class="row justify-content-center">
                        <p class="col-6 text-right">Phone Verified:</p>
                        <p class="col-6 text-left">
                            @if($g_user->phone_confirmed == 1)
                                <i class="fa fa-check-circle-o text-success fa-2x" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-times-circle-o text-danger fa-2x" aria-hidden="true"></i>
                                (verify)
                            @endif
                        </p>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="d-flex">
                    <div class="card col-2 py-2 text-center"><b>{{ $datalist['UserDetail']['level'] }}</b><br>Level</div>
                    <div class="card col-10 py-2">
                        <div class="progress">
                            <div class="progress-bar bg-danger" style="width:70%"></div>
                        </div>
                            <p class="text-right">{{ $datalist['UserDetail']['LevelProgress'] }} / {{ $datalist['UserDetail']['LevelCap'] }}</p>
                    </div>
                </div>
                <div class="card" id="statistics">

                    <div style="text-align: center; padding: 10px" id="loader">
                        <img src="{{ url('img/loader.gif') }}" height="32px">
                    </div>
                    {{--<div class="card" id="statistics">--}}
                        {{--<div class="card-block text-center justify-content-center">--}}
                            {{--<h3>TOTAL ACTIVITY</h3>--}}

                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--User Id:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['last_login']->user_id }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--Referrer:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['last_login']->referrer }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--Ip:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['last_login']->ip }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--Hostname:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['last_login']->hostname }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--City:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['last_login']->city }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--Region:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['last_login']->region }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--Country:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['last_login']->country }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--Loc:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['last_login']->loc }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--Org:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['last_login']->org }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--Postal:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['last_login']->postal }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<hr>--}}

                        {{--<div class="card-block text-center justify-content-center">--}}

                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--<i class="fa fa-wifi" aria-hidden="true"></i>--}}
                                    {{--Post:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['posts'] }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--<i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>--}}
                                    {{--Logins:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['login_count'] }}--}}
                                {{--</div>--}}
                            {{--</div>--}}


                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--<i class="fa fa-arrow" aria-hidden="true"></i>--}}
                                    {{--Days of activity:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['active_days'] }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--<i class="fa fa-arrow" aria-hidden="true"></i>--}}
                                    {{--Last activity:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['last_login']->created_at }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--<i class="fas fa-fire"></i>--}}
                                    {{--Current streak:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['streak_login_current'] }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--<i class="fa fa-fire"></i>--}}
                                    {{--Longest streak:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['streak_login_max'] }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--<i class="fa fa-user-circle" aria-hidden="true"></i>--}}
                                    {{--Accounts:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['accounts'] }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--<i class="fa fa-user-circle-o" aria-hidden="true"></i>--}}
                                    {{--Website domains:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['domains'] }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--<i class="fa " aria-hidden="true"></i>--}}
                                    {{--Page Updates:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $datalist['Activity_summary']['Page Updates'] }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--<i class="fa fa-user" aria-hidden="true"></i>--}}
                                    {{--Website Visits:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $datalist['Activity_summary']['Website Visits'] }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--<i class="fa fa-user" aria-hidden="true"></i>--}}
                                    {{--User invitations:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $datalist['Activity_summary']['User invitations'] }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--<i class="fa fa-flag" aria-hidden="true"></i>--}}
                                    {{--Email subscribers:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $statistics['subscribers'] }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row justify-content-center">--}}
                                {{--<div class="col-5 text-left">--}}
                                    {{--<i class="fa fa-telegram" aria-hidden="true"></i>--}}
                                    {{--Email sent:--}}
                                {{--</div>--}}
                                {{--<div class="col-4 text-left">--}}
                                    {{--{{ $datalist['Activity_summary']['Email sent'] }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
            <div class="col-md-12">
                <div class="card py-3 text-center justify-content-center">
                    <h4>You made {{ $datalist['MainAchievements']['PostsThisMonth'] }} posts this month!</h4>
                    <h3>REWARDS</h3>
                    <div class="d-flex justify-content-center">
                        @foreach(json_decode(json_encode($datalist['MainAchievements']['RewardIcons']),true) as $key => $value)
                            <div class="text-center mx-2">
                                @if($value['Icon']=="Checkmark")
                                <i class="fa fa-check-circle-o text-success fa-3x" aria-hidden="true"></i>
                                @endif
                                @if($value['Icon']=="Question")
                                        <i class="fa fa-question fa-3x text-dark text-black" aria-hidden="true"></i>
                                @endif
                                <br>
                                <i>{{ $value['Name'] }}</i><br>
                                <i>{{ $value['Detail'] }}</i>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card py-3 text-center justify-content-center">
                    <h4>MEDALS</h4>
                    <div class="row">
                        <div class="col-12 d-flex flex-wrap">
                            <div class="border border-orange rounded-circle media-icon">
                                <i class="fa fa-bell-o fa-2x" aria-hidden="true"></i>
                            </div>
                            <div class="border border-orange rounded-circle media-icon">
                                <i class="fa fa-bicycle fa-2x" aria-hidden="true"></i>
                            </div>
                            <div class="border border-orange rounded-circle media-icon">
                                <i class="fa fa-bell fa-2x" aria-hidden="true"></i>
                            </div>
                            <div class="border border-orange rounded-circle media-icon">
                                <i class="fa fa-bicycle fa-2x" aria-hidden="true"></i>
                            </div>
                            <div class="media-icon">
                                <i class="fa fa-book fa-2x" aria-hidden="true"></i>
                                <div class="progress">
                                    <div class="progress-bar bg-danger" style="width:70%"></div>
                                </div>
                            </div>
                            <div class="media-icon">
                                <i class="fa fa-book fa-2x" aria-hidden="true"></i>
                                <div class="progress">
                                    <div class="progress-bar bg-danger" style="width:70%"></div>
                                </div>
                            </div>
                            <div class="media-icon">
                                <i class="fa fa-book fa-2x" aria-hidden="true"></i>
                                <div class="progress">
                                    <div class="progress-bar bg-danger" style="width:70%"></div>
                                </div>
                            </div>
                            <div class="media-icon">
                                <i class="fa fa-book fa-2x lock" aria-hidden="true"></i>
                                <i class="fa fa-lock fa-2x" aria-hidden="true"></i>
                            </div>
                            <div class="media-icon">
                                <i class="fa fa-bell fa-2x lock" aria-hidden="true"></i>
                                <i class="fa fa-lock fa-2x" aria-hidden="true"></i>
                            </div>
                            <div class="media-icon">
                                <i class="fa fa-bell fa-2x lock" aria-hidden="true"></i>
                                <i class="fa fa-lock fa-2x" aria-hidden="true"></i>
                            </div>
                            <div class="media-icon">
                                <i class="fa fa-bell fa-2x lock" aria-hidden="true"></i>
                                <i class="fa fa-lock fa-2x" aria-hidden="true"></i>
                            </div>
                            <div class="media-icon">
                                <i class="fa fa-bell fa-2x lock" aria-hidden="true"></i>
                            </div>
                            <div class="media-icon">
                                <i class="fa fa-bell fa-2x lock" aria-hidden="true"></i>
                            </div>
                            <div class="media-icon">
                                <i class="fa fa-bell fa-2x lock" aria-hidden="true"></i>
                            </div>
                            <div class="media-icon">
                                <i class="fa fa-bell fa-2x lock" aria-hidden="true"></i>
                            </div>
                            <div class="media-icon">
                                <i class="fa fa-bell fa-2x lock" aria-hidden="true"></i>
                            </div>
                            <div class="media-icon">
                                <i class="fa fa-bell fa-2x lock" aria-hidden="true"></i>
                            </div>
                            <div class="media-icon">
                                <i class="fa fa-bell fa-2x lock" aria-hidden="true"></i>
                            </div>
                            <div class="media-icon">
                                <i class="fa fa-bell fa-2x lock" aria-hidden="true"></i>
                            </div>
                            <div class="media-icon">
                                <i class="fa fa-bell fa-2x lock" aria-hidden="true"></i>
                            </div>
                            <div class="media-icon">
                                <i class="fa fa-bell fa-2x lock" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            @foreach(json_decode(json_encode($datalist['Achievements']),true) as $key => $value)

                <div class="col-md-4">
                    <a href="{{ route('user.badge',$value['id']) }}" style="color: black">
                    <div class="card py-3 h-card text-center">
                        <h5 class="mb-3 font-weight-bolder">
                            {{ $value['Title'] }}
                        </h5>

                        @if($value['AchievedDate']!=null)
                            <img style="max-height: 150px; max-width:100%;" src="{{ url('img/badges/'.$value['IconURL']) }}">
                        <p class="mt-2 h6">Achieved {{ $value['AchievedDate'] }}</p>
                        @else
                            <div class="progress">
                                <div class="progress-bar bg-danger" style="width:50%"></div>
                            </div>
                        @endif

                        @if(isset($value['link']))
                            <a class="btn btn-primary" href="{{url()->current() . $value['link']}}">
                                Restart Interview
                            </a>
                        @endif
                    </div>
                    </a>
                </div>

            @endforeach
        </div>


@endsection

@section('modal')
    {{--@include('fe.interviews._modals')--}}
@endsection

@section('js')
<script src="{{ mix('/stuff/standalone.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#saveAvatar').hide();
        $('#featured_image').on('change', function(){
            $('#saveAvatar').show();
        });
        if($('#featured_image').val() != '') {
            $('#saveAvatar').show();
        }

        $.ajax(
            {url: "{{ route('user.statistics.static') }}",
            timeout: 480000 ,
            success: function(result)
                {
                    $('#loader').hide();

                    var json = JSON.parse(result);
                    var data = "";
                    var cnt = 1;
                    var tot =1;

                    data +='<div class="card-block text-center justify-content-center">' +
                                '<h3>TOTAL ACTIVITY</h3>' +
                                '<div class="row justify-content-center">'+
                                    '<div class="col-5 text-left">User Id:</div>'+
                                    '<div class="col-4 text-left">'+json['last_login']['user_id'] +'</div>'+
                                '</div>' +
                                '<div class="row justify-content-center">'+
                                        '<div class="col-5 text-left">Referrer:</div>'+
                                        '<div class="col-4 text-left">'+json['last_login']['referrer'] +'</div>'+
                                '</div>' +
                                '<div class="row justify-content-center">'+
                                        '<div class="col-5 text-left">Ip:</div>'+
                                        '<div class="col-4 text-left">'+json['last_login']['ip'] +'</div>'+
                                '</div>' +
                                '<div class="row justify-content-center">'+
                                        '<div class="col-5 text-left">Hostname:</div>'+
                                        '<div class="col-4 text-left">'+json['last_login']['hostname'] +'</div>'+
                                '</div>' +
                                '<div class="row justify-content-center">'+
                                        '<div class="col-5 text-left">City:</div>'+
                                        '<div class="col-4 text-left">'+json['last_login']['city'] +'</div>'+
                                '</div>' +
                                '<div class="row justify-content-center">'+
                                        '<div class="col-5 text-left">Region:</div>'+
                                        '<div class="col-4 text-left">'+json['last_login']['region'] +'</div>'+
                                '</div>' +
                                '<div class="row justify-content-center">'+
                                        '<div class="col-5 text-left">Country:</div>'+
                                        '<div class="col-4 text-left">'+json['last_login']['country'] +'</div>'+
                                '</div>' +
                                '<div class="row justify-content-center">'+
                                        '<div class="col-5 text-left">Loc:</div>'+
                                        '<div class="col-4 text-left">'+json['last_login']['loc'] +'</div>'+
                                '</div>' +
                                '<div class="row justify-content-center">'+
                                        '<div class="col-5 text-left">Org:</div>'+
                                        '<div class="col-4 text-left">'+json['last_login']['org'] +'</div>'+
                                '</div>' +
                                '<div class="row justify-content-center">'+
                                        '<div class="col-5 text-left">Postal:</div>'+
                                        '<div class="col-4 text-left">'+json['last_login']['postal'] +'</div>'+
                                '</div>' +

                            '</div>' +
                            '<hr>' +
                            '<div class="card-block text-center justify-content-center">' +
                                '<div class="row justify-content-center">'+
                                    '<div class="col-5 text-left">Post:</div>'+
                                    '<div class="col-4 text-left">'+json['posts'] +'</div>'+
                                '</div>' +
                                '<div class="row justify-content-center">'+
                                    '<div class="col-5 text-left">Logins:</div>'+
                                    '<div class="col-4 text-left">'+json['login_count'] +'</div>'+
                                '</div>' +
                                '<div class="row justify-content-center">'+
                                    '<div class="col-5 text-left">Last activity:</div>'+
                                    '<div class="col-4 text-left">'+json['last_login']['created_at'] +'</div>'+
                                '</div>' +
                                '<div class="row justify-content-center">'+
                                    '<div class="col-5 text-left">Current streak:</div>'+
                                    '<div class="col-4 text-left">'+json['streak_login_current'] +'</div>'+
                                '</div>' +
                                '<div class="row justify-content-center">'+
                                    '<div class="col-5 text-left">Longest streak:</div>'+
                                    '<div class="col-4 text-left">'+json['streak_login_max'] +'</div>'+
                                '</div>' +
                                '<div class="row justify-content-center">'+
                                    '<div class="col-5 text-left">Accounts:</div>'+
                                    '<div class="col-4 text-left">'+json['accounts'] +'</div>'+
                                '</div>' +
                                '<div class="row justify-content-center">'+
                                    '<div class="col-5 text-left">Website domains:</div>'+
                                    '<div class="col-4 text-left">'+json['domains'] +'</div>'+
                                '</div>' +
                                '<div class="row justify-content-center">'+
                                    '<div class="col-5 text-left">Email subscribers::</div>'+
                                    '<div class="col-4 text-left">'+json['subscribers'] +'</div>'+
                                '</div>' +
                            '</div>';

                    $("#statistics").html(data);
            }}
        );
    });
</script>
@endsection