@extends('layouts.app')
@section('css')
<style type="text/css">
    .account-title {
        font-weight: bold;
    }
</style>
@endsection
@section('content')
@if($headless != true)
@if($hidetitle != true)
<div>
    <h1 class="page-heading">Accounts</h1>
</div>
@endif
@include('teamwork._nav')
@endif
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <h4 class="card-title">Current Account</h4>
                    <div class="media-body media-middle">
                        <div class="pull-right">
                            <a href="{{route('teams.edit', $current_team)}}" class="btn btn-sm btn-primary">
                                <i class="fa fa-edit"></i>
                                Edit
                            </a>
                            <a href="{{route('teams.members.index')}}" class="btn btn-sm btn-primary">
                                <i class="fa fa-users"></i>
                                Users
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="media">
                        <div class="media-body media-middle">
                            <div class="row-fluid">
                                <div class="col-md-4 account-title text-md-right">Website Name</div>
                                <div class="col-md-8">{{ $current_team->name }}</div>
                            </div>
                        </div>
                    </div>
                </li>
                @foreach(['timezone'/* ,'phone','website','facebook','twitter','linkedin','instagram','youtube','yelp' */] as $field)
                <li class="list-group-item">
                    <div class="media">
                        <div class="media-body media-middle">
                            <div class="row-fluid">
                                <div class="col-md-4 account-title text-md-right">{{ ucwords($field) }}</div>
                                <div class="col-md-8">
                                    {{ isset($current_team->{$field}) ? $current_team->{$field} : 'none' }}</div>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
                <li class="list-group-item">
                    <div class="media">
                        <div class="media-body media-middle">
                            <div class="row-fluid">
                                <div class="col-md-4 account-title text-md-right">In Account Switcher</div>
                                <div class="col-md-8">
                                    {{ (isset($current_team->pivot) && $current_team->pivot->menu_suppression == 1) ? 'No' : 'Yes' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-success btn-sm pull-right" href="{{route('teams.create')}}">
                    <i class="fa fa-plus"></i> Create Account
                </a>
                <h4 class="card-title">Accounts</h4>
            </div>
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teams as $team)
                    <tr>
                        <td>{{$team->name}}</td>
                        <td>
                            @if(auth()->user()->isOwnerOfTeam($team))
                            <span class="label label-success">Owner</span>
                            @else
                            <span class="label label-primary">Member</span>
                            @endif
                        </td>
                        <td>
                            @if(is_null(auth()->user()->currentTeam) || auth()->user()->currentTeam->getKey() !==
                            $team->getKey())
                            @if($headless != true)
                            <a href="{{route('teams.switch', $team)}}" class="btn btn-sm btn-default">
                                <i class="fa fa-sign-in"></i> Switch
                            </a>
                            @endif
                            @else
                            <span class="label label-default">Current Account</span>
                            @endif
                            <a href="{{route('teams.members.index')}}" class="btn btn-sm btn-default">
                                <i class="fa fa-users"></i> Users
                            </a>

                            <a href="{{route('teams.edit', $team)}}" class="btn btn-sm btn-default">
                                <i class="fa fa-pencil"></i> Edit
                            </a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
</div>
@endsection
