@extends('fe.layouts.app')

@section('content')
<div>
	<a href="{{route('campaigns.index')}}" class="btn btn-default btn-sm pull-right" style="margin-top: 22px;">
		<i class="fa fa-arrow-left"></i> Back
	</a>
	<h1 class="page-heading">Email Blasts - Create</h1>
</div>

<ol class="breadcrumb">
	<li><a href="{{ route('homebc') }}">Home</a></li>
	<li><a href="{{ route('campaigns.index') }}">Email Blasts</a></li>
	<li class="active">Create</li>
</ol>

<form method="post" action="{{route('campaigns.store')}}" id="editor_form">
	{!! csrf_field() !!}
	@include('fe.campaigns._form')
</form>

@endsection
