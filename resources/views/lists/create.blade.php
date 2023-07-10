@extends('layouts.app')
@section('content')
<div>
@if ( !empty($defaultListId) )
    <a href="{{ route('lists.subscribers', ['list'=>$defaultListId]) }}" class="btn btn-default btn-sm pull-right" style="margin-top: 22px;">
        <i class="fa fa-arrow-left"></i> Back
    </a>
@else
    <a href="{{ route('lists.index' )}}" class="btn btn-default btn-sm pull-right" style="margin-top: 22px;">
        <i class="fa fa-arrow-left"></i> Back
    </a>
@endif
    <h1 class="page-heading">List - Create</h1>
</div>
<div class="row-fluid">
	<div class="col-md-6 col-md-offset-3">
		<div class="card card-primary">
			<div class="card-block">
				
                @include('lists._form')
				
			</div>
		</div>
	</div>
</div>

@endsection
