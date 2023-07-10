@extends('layouts.app')
@section('content')
<div>
	<a href="{{route('campaigns.index')}}" class="btn btn-default btn-sm pull-right" style="margin-top: 22px;">
		<i class="fa fa-arrow-left"></i> Back
	</a>
	<h1 class="page-heading">Email Blasts - Show</h1>
</div>


	{{ $marketingCampaign }}

@endsection
