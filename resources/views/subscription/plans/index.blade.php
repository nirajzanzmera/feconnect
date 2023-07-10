@extends('layouts.app')
@section('content')
<div>
    <h1 class="page-heading">Accounts</h1>
</div>
<ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li><a href="{{ route('teams.index') }}">Accounts</a></li>
    <li>Plans</li>
</ol>
@include('subscription._nav')
<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Plans</h4>
                        <p class="card-subtitle"></p>
                    </div>
                    <div class="media-right media-middle">
                       
                        

                    </div>
                </div>
            </div>
            <div class="card-block">
                <p>
                    <strong>Current Plan: </strong>
                    @if(empty($current_plan))
                    None, select a plan below to start sending!
                    @else
                        {{ $current_plan->name }} - ${{ $current_plan->price }} {{ $current_plan->frequency }}
                        <br />
                        <strong>Current Status: </strong>
                        @if( empty($main_sub->ends_at) )
                            <span class="label label-success">Active</span>
                        @else
                            <span class="label label-danger">Canceled</span>
                        <br />
                        <small>
                        Expires: {{ $main_sub->ends_at->format('m/d/Y') }}
                        </small>
                        @endif
                        @if($main_sub->onTrial('main') )
                        <br />
                            <strong>On Trial: </strong><span class="label label-success">Yes</span>
                        <br />
                            <strong>Trial Ends: </strong> {{ $main_sub->trial_ends_at->format('m/d/Y') }}
                        @endif

                    @endif
                </p>
            </div>      
            @include('subscription.plans._table')
        </div>
    </div>
</div>

@endsection


@section('js')

@endsection
