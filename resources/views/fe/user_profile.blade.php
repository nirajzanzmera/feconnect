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

        <div class="row">
    <div class="col-md-12">
        <div class="card p-4">
            <div class="d-flex align-items-center">
                <span>Avatar</span>
                <img src="https://www.freepik.com/free-vector/farmer-using-technology-digital-agriculture_16310216.htm#page=1&amp;query=avatar&amp;position=15&amp;from_view=search" class="img-thumbnail img-fluid ml-5" alt="user image">
                <button class="btn btn-primary ml-5">Choose replacement</button>
            </div>
        </div>
        <div class="card">
            <div class="card-block pb-2 d-flex align-items-center">
                <span class="col-sm-2">Your name</span>
                <span class="col-sm-4">{{ $g_user->name}}</span>
                <button class="btn btn-primary ml-5">Edit</button>
            </div>
            <div class="card-block pt-0 d-flex align-items-center">
                <span class="col-sm-2">Your nickname</span>
                <span class="col-sm-4">{{ $datalist['UserDetail']['Nickname'] }}</span>
                <button class="btn btn-primary ml-5">Edit</button>
            </div>
        </div>
        <div class="card">
            <div class="card-block pb-2 d-flex align-items-center">
                <div class="col-sm-6">
                    <span class="col-6">Email Verified:</span>
                    <span class="col-6">
                        @if($g_user->email_confirmed == 1)
                            <i class="fa fa-check-circle-o text-success fa-2x" aria-hidden="true"></i>
                        @else
                            <i class="fa fa-times-circle-o text-danger fa-2x" aria-hidden="true"></i>
                            (verify)
                        @endif
                    </span>
                </div>
                <div class="col-sm-6">
                    <span class="col-8">{{ $g_user->email }}</span>
                    <button class="col-4 btn btn-primary ml-5">Change</button>
                </div>
            </div>
            <div class="card-block pt-0 d-flex align-items-center">
                <div class="col-sm-6">
                    <span class="col-8">Phone Verified:</span>
                    <span class="col-4">
                         @if($g_user->phone_confirmed == 1)
                            <i class="fa fa-check-circle-o text-success fa-2x" aria-hidden="true"></i>
                        @else
                            <i class="fa fa-times-circle-o text-danger fa-2x" aria-hidden="true"></i>
                            (verify)
                        @endif
                    </span>
                </div>
                <div class="col-sm-6">
                    <span class="col-6">{{ $g_user->phone }}</span>
                    <button class="col-6 btn btn-primary ml-5">Change</button>
                </div>
            </div>

        </div>
        <div class="card">
            <div class="card-block d-flex align-items-center">
                <span class="col-sm-2">Timezone</span>
                <span class="col-sm-4">{{ $team->timezone }}</span>
                <button class="btn btn-primary ml-5">Edit</button>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-block text-center justify-content-center">
                <h3>ABOUT YOU</h3>
            </div>
            <div class="card-block card-block-light ml-3">
                <fieldset class="form-group ">
                    <label for="address" class="col-md-2 form-control-label" style="text-align:right" title="Address">Address</label>
                    <div class="col-md-8">
                        <input id="address" class="form-control" name="address" value="{{ $team->address }}">
                    </div>
                </fieldset>
                <fieldset class="form-group ">
                    <label for="address2" class="col-md-2 form-control-label" style="text-align:right" title="Address 2">Address2</label>
                    <div class="col-md-8">
                        <input id="address2" class="form-control" name="address2" value="{{ $team->address_2 }}">
                    </div>
                </fieldset>
                <fieldset class="form-group ">
                    <label for="city" class="col-md-2 form-control-label" style="text-align:right" title="City">City</label>
                    <div class="col-md-8">
                        <input id="city" class="form-control" name="city" value="{{ $team->city }}">
                    </div>
                </fieldset>
                <fieldset class="form-group ">
                    <label for="state" class="col-md-2 form-control-label" style="text-align:right" title="State">State</label>
                    <div class="col-md-8">
                        <input id="state" class="form-control" name="state" value="{{ $team->state }}">
                    </div>
                </fieldset>
                <fieldset class="form-group ">
                    <label for="zip" class="col-md-2 form-control-label" style="text-align:right" title="zip">Zip</label>
                    <div class="col-md-8">
                        <input id="zip" class="form-control" name="zip" value="{{ $team->zip }}">
                    </div>
                </fieldset>
                <fieldset class="form-group ">
                    <label for="phone" class="col-md-2 form-control-label" style="text-align:right">Phone</label>
                    <div class="col-md-8">
                        <input id="phone" class="form-control" name="phone" value="{{ $team->phone }}">
                    </div>
                </fieldset>
                <h3 class="ml-5 my-4">Social Links</h3>
                <fieldset class="form-group ">
                    <label for="facebook" class="col-md-2 form-control-label" style="text-align:right">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </label>
                    <div class="col-md-8">
                        <input id="facebook" class="form-control" name="facebook" value="{{ $team->facebook }}">
                    </div>
                </fieldset>
                <fieldset class="form-group ">
                    <label for="twitter" class="col-md-2 form-control-label" style="text-align:right">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </label>
                    <div class="col-md-8">
                        <input id="twitter" class="form-control" name="twitter" value="{{ $team->twitter }}">
                    </div>
                </fieldset>
                <fieldset class="form-group ">
                    <label for="linkedin" class="col-md-2 form-control-label" style="text-align:right">
                        <i class="fa fa-linkedin" aria-hidden="true"></i>
                    </label>
                    <div class="col-md-8">
                        <input id="linkedin" class="form-control" name="linkedin" value="{{ $team->linkedin }}">
                    </div>
                </fieldset>
                <fieldset class="form-group ">
                    <label for="instagram" class="col-md-2 form-control-label" style="text-align:right">
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </label>
                    <div class="col-md-8">
                        <input id="instagram" class="form-control" name="instagram" value="{{ $team->instagram }}">
                    </div>
                </fieldset>
                <fieldset class="form-group ">
                    <label for="youtube" class="col-md-2 form-control-label" style="text-align:right">
                        <i class="fa fa-youtube" aria-hidden="true"></i>
                    </label>
                    <div class="col-md-8">
                        <input id="youtube" class="form-control" name="youtube" value="{{ $team->youtube }}">
                    </div>
                </fieldset>
                <fieldset class="form-group ">
                    <label for="yelp" class="col-md-2 form-control-label" style="text-align:right">
                        <i class="fa fa-yelp" aria-hidden="true"></i>
                    </label>
                    <div class="col-md-8">
                        <input id="yelp" class="form-control" name="yelp" value="{{ $team->yelp }}">
                    </div>
                </fieldset>
                <fieldset class="form-group ">
                    <label for="about" class="col-md-12 mt-2 form-control-label">
                        What do you want people to know about you?
                    </label>
                    <div class="col-md-12">
                        <textarea name="about" class="form-control" id="about" cols="30" rows="5">{{ $team->description }}</textarea>
                    </div>
                </fieldset>

                <button class="btn btn-md btn-primary">Update</button>

            </div>
        </div>
        {{--<div class="card">--}}
            {{--<div class="card-block text-center justify-content-center">--}}
                {{--<h3>STATISTICS</h3>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Created:--}}
                    {{--</div>--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--{{ date('d/m/Y',strtotime($statistics['created_at']->date)) }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Last Login:--}}
                    {{--</div>--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--{{ date('d/m/Y',strtotime($statistics['last_login']->created_at)) }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Last Login IP:--}}
                    {{--</div>--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--{{ $statistics['last_login']->ip }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Hostname:--}}
                    {{--</div>--}}
                    {{--<div class="col-4 text-left">--}}
                        {{--{{ $statistics['last_login']->hostname }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--City:--}}
                    {{--</div>--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--{{ $statistics['last_login']->city }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Region:--}}
                    {{--</div>--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--{{ $statistics['last_login']->region }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Country:--}}
                    {{--</div>--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--{{ $statistics['last_login']->country }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Loc:--}}
                    {{--</div>--}}
                    {{--<div class="col-5 text-left">--}}
                        {{--{{ $statistics['last_login']->loc }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Total logins:--}}
                    {{--</div>--}}
                    {{--<div class="col-5 text-left">--}}
                        {{--{{ $datalist['Activity_summary']['Total logins'] }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Total time:--}}
                    {{--</div>--}}
                    {{--<div class="col-5 text-left">--}}
                        {{--{{ $datalist['Activity_summary']['Total time'] }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="px-4">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-sm-3 text-left">--}}
                            {{--Total time per section:--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                            {{--Time--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-1 text-left">--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                            {{--Last: 7 days--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                            {{--30 days--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                            {{--90 days--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-sm-3 text-center">--}}
                            {{--Websites:--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                            {{--{{ $datalist['Activity_summary']['Websites'] }}--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-1 text-left">--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}

                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}

                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}

                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-sm-3 text-right">--}}
                            {{--Posts:--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-1 text-left">--}}
                            {{--{{ $datalist['Activity_summary']['Posts'] }}--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                            {{--X--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                            {{--X--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                            {{--X--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-sm-3 text-right">--}}
                            {{--Pages:--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-1 text-left">--}}
                            {{--{{ $datalist['Activity_summary']['Pages'] }}--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                            {{--X--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                            {{--X--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                            {{--X--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-sm-3 text-right">--}}
                            {{--Others:--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-1 text-left">--}}
                            {{--{{ $datalist['Activity_summary']['Others'] }}--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                            {{--X--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                            {{--X--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                            {{--X--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-sm-3 text-center">--}}
                            {{--Emails:--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                            {{--{{ $datalist['Activity_summary']['Emails'] }}--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-1 text-left">--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}

                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}

                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}

                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-sm-3 text-center">--}}
                            {{--Domains:--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                            {{--{{ $datalist['Activity_summary']['Domains'] }}--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-1 text-left">--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}

                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}

                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}

                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-sm-3 text-center">--}}
                            {{--User Profile:--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}
                            {{--{{ $datalist['Activity_summary']['User Profile'] }}--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-1 text-left">--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}

                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}

                        {{--</div>--}}
                        {{--<div class="col-sm-2 text-left">--}}

                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Post:--}}
                    {{--</div>--}}
                    {{--<div class="col-5 text-left">--}}
                        {{--{{ $statistics['posts'] }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Logins:--}}
                    {{--</div>--}}
                    {{--<div class="col-5 text-left">--}}
                        {{--{{ $statistics['login_count'] }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Days of activity:--}}
                    {{--</div>--}}
                    {{--<div class="col-5 text-left">--}}
                        {{--{{ $statistics['active_days'] }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Last activity:--}}
                    {{--</div>--}}
                    {{--<div class="col-5 text-left">--}}
                        {{--{{ date('d/m/Y',strtotime($statistics['last_login']->created_at)) }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Current streak:--}}
                    {{--</div>--}}
                    {{--<div class="col-5 text-left">--}}
                        {{--{{ $statistics['streak_login_current'] }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Longest streak:--}}
                    {{--</div>--}}
                    {{--<div class="col-5 text-left">--}}
                        {{--{{ $statistics['streak_login_max'] }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Accounts:--}}
                    {{--</div>--}}
                    {{--<div class="col-5 text-left">--}}
                        {{--{{ $statistics['accounts'] }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Website domains:--}}
                    {{--</div>--}}
                    {{--<div class="col-5 text-left">--}}
                        {{--{{ $statistics['domains'] }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Page Updates:--}}
                    {{--</div>--}}
                    {{--<div class="col-5 text-left">--}}
                        {{--{{ $datalist['Activity_summary']['Page Updates'] }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Website Visits:--}}
                    {{--</div>--}}
                    {{--<div class="col-5 text-left">--}}
                        {{--{{ $datalist['Activity_summary']['Website Visits'] }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--User invitations:--}}
                    {{--</div>--}}
                    {{--<div class="col-5 text-left">--}}
                        {{--{{ $datalist['Activity_summary']['User invitations'] }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Email subscribers:--}}
                    {{--</div>--}}
                    {{--<div class="col-5 text-left">--}}
                        {{--{{ $statistics['subscribers'] }}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row px-4">--}}
                    {{--<div class="col-3 text-left">--}}
                        {{--Email sent:--}}
                    {{--</div>--}}
                    {{--<div class="col-5 text-left">--}}
                        {{--{{ $datalist['Activity_summary']['Email sent'] }}--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>

</div>

@endsection