@extends('layouts.app')

@section('content')
<div>
    <a href="{{route('campaigns.index')}}" class="btn btn-default btn-sm pull-right" style="margin-top: 22px;">
        <i class="fa fa-arrow-left"></i> Back
    </a>
    <h1 class="page-heading">Email Blasts - Duplicate</h1>
</div>

<ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li><a href="{{ route('campaigns.index') }}">Email Blasts</a></li>
    <li class="active">Duplicate</li>
</ol>

@if($errors->count() > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif

<form method="post" action="{{route('campaigns.store')}}" id="campaign_form">
	{!! csrf_field() !!}
	@include('campaigns._form')
</form>

@endsection
