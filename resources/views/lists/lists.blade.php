@extends('layouts.app')


@section('content')
	
	<div>
		<a class="btn btn-success btn-sm pull-right" style="margin-top: 22px;" href="{{route('lists.create')}}">
			<i class="fa fa-plus"></i> Create list
		</a>
		<h1 class="page-heading">Lists</h1>
	</div>
@include('lists._nav')    
<div class="row-fluid">
	<div class="col-md-8">	
		<div class="card">
			<div class="card-block">
				<table class="table">
				@foreach($lists as $list)
					<tr>
						<td>
							<strong>{{ $list->name }}</strong> : 
							Subscribers: {{ $list->subscribers_count }}
							<div class="label label-info">{{ $list->status }}</div>

							<div class="btn-group pull-right">
									
									<a href="{{ route('lists.upload', $list) }}" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> Upload</a>
									<a href="{{ route('lists.edit', $list) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Manage</a>
									
							</div>
							
						</td>
					</tr>
				@endforeach

				</table>
			</div>
		</div>
	</div>
</div>
	
@endsection
