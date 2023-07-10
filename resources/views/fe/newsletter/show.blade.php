@extends('fe.layouts.app')
@section('content')
<div>
	<a href="{{route('newsletters.index')}}" class="btn btn-default btn-sm pull-right" style="margin-top: 22px;">
		<i class="fa fa-arrow-left"></i> Back
	</a>
	<h1 class="page-heading">Newsletter - Preview</h1>
</div>

{{-- <ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li><a href="{{ route('newsletters.index') }}">Newsletter</a></li>
    <li class="active">Preview</li>
</ol> --}}
@include('fe.campaigns._nav')
<div class="row-fluid">
	<div class="col-md-12">
		<div class="card">
			<div class="card-block">
            preview...
                
			</div>
		</div>
	</div>
</div>
@endsection
