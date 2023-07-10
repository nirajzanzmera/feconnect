@extends('layouts.app')
@section('content')
<div>
    <a href="{{route('campaigns.index')}}" class="btn btn-default btn-sm pull-right" style="margin-top: 22px;">
        <i class="fa fa-arrow-left"></i> Back
    </a>
    <h1 class="page-heading">Email Blasts - Copy</h1>
</div>
<ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li><a href="{{ route('campaigns.index') }}">Email Blasts</a></li>
    <li class="active">Copy to</li>
</ol>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Email Info</h4>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <strong>DATE:</strong> {{ $campaign->send_date }}<br />
                            <strong>TIME:</strong> {{ $campaign->send_time }} {{ Auth::user()->currentTeam->send_timezone }}<br />
                        </div>
                        <strong>TO:</strong> {{ isset($campaign->list->name) ? $campaign->list->name : ''  }}<br />
                        <strong>FROM:</strong> {{ isset($campaign->sender->email) ? $campaign->sender->email : ''  }}<br />
                        <strong>SUBJECT:</strong> {{ $campaign->subject }}<br />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Copy Email to...</h4>
                <p class="card-subtitle">
                    Use the buttons below to copy a Email blast to templates, other emails, etc.
                </p>
            </div>

                <ul class="list-group">
                    <li class="list-group-item list-group-flush">
                        <a href="{{ route('templates.create', $campaign) }}" class="btn btn-info"><i class="fa fa-clone"></i> Copy to Template</a>
                    </li>
                    <li class="list-group-item list-group-flush">
                        <a href="{{ route('campaigns.duplicate', $campaign) }}" class="btn btn-info"><i class="fa fa-copy"></i> Copy to Email Blast</a>
                    </li>
                </ul>

        </div>
    </div>
</div>
@endsection
