@extends('fe.layouts.app')
@section('content')
        <div>
            <h1 class="page-heading">Accounts</h1>
        </div>
@include('fe.teamwork._nav')
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="media">
                            <h4 class="card-title">Current Account</h4>
                            <div class="media-body media-middle">
                                <div class="pull-right">
                                    <a href="{{ route('teams.edit',['id' => $website->account_id]) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
                                        Edit
                                    </a>
                                    <a href="{{ route('teams.members.index') }}" class="btn btn-sm btn-primary">
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
                                        <div class="col-md-8">{{ $team->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="media">
                                <div class="media-body media-middle">
                                    <div class="row-fluid">
                                        <div class="col-md-4 account-title text-md-right">Timezone</div>
                                        <div class="col-md-8">{{ $team->timezone }}</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="media">
                                <div class="media-body media-middle">
                                    <div class="row-fluid">
                                        <div class="col-md-4 account-title text-md-right">In Account Switcher</div>
                                        <div class="col-md-8">
                                            @foreach($teams as $tm)
                                                @if($tm->account_id == $website->account_id)
                                                    @if($tm->pivot->menu_suppression == 0) {{ 'Yes' }} @endif
                                                    @if($tm->pivot->menu_suppression == 1) {{ 'No' }} @endif
                                                @endif
                                            @endforeach
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
                        <a class="btn btn-success btn-sm pull-right" href="{{ route('teams.create') }}">
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
                        @foreach($teams as $tm)
                        <tr>
                            <td>{{ $tm->account_name }}</td>
                            <td>
                                <span class="label label-success">Owner</span>
                            </td>
                            <td>
                                @if($tm->account_id == $website->account_id)
                                <span class="label label-default">Current Account</span>
                                @else
                                    <a href="{{ route('teams.switch',['id' => $tm->account_id ]) }}" class="btn btn-sm btn-default">
                                        <i class="fa fa-sign-in"></i> Switch
                                    </a>
                                @endif
                                <a href="{{ route('teams.members.index') }}" class="btn btn-sm btn-default">
                                    <i class="fa fa-users"></i> Users
                                </a>

                                <a href="{{ route('teams.edit',['id' => $tm->account_id]) }}" class="btn btn-sm btn-default">
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

@section('css')
    <style type="text/css">
    </style>
@endsection

@section('js')
    @include('fe.layouts._popover')
@endsection