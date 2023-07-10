@extends('layouts.app')
@section('content')
<div>
	<a href="{{ route('lists.index' )}}" class="btn btn-default btn-sm pull-right" style="margin-top: 22px;">
		<i class="fa fa-arrow-left"></i> Back
	</a>
	<h1 class="page-heading">List - Manage : {{ $list->name }} list</h1>
    @include('lists._nav')
</div>
<div class="row-fluid">
	<div class="col-md-6 col-md-offset-3">
		<div class="card card-primary">
			<div class="card-block">
				<form method="post" action="{{ empty($list) ? route('lists.store') : route('lists.update', $list) }}">
					{!! csrf_field() !!}
					{{ empty($list) ? '' : method_field('PUT') }}
					
					<div class="row form-group{{ $errors->has('name') ? ' has-error' : '' }}">
						<label class="col-md-2 form-control-label">Name</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="name" value="{{ old('name', !empty($list->name) ? $list->name : NULL ) }}">
							@if ($errors->has('name'))
								<span class="help-block">
									<strong>{{ $errors->first('name') }}</strong>
								</span>
							@endif
						</div>
					</div>
					
					<div class="row form-group">
						<div class="col-md-6 col-md-offset-2">
							<button type="submit" class="btn btn-success">
							<i class="fa fa-btn fa-save"></i> {{ empty($list) ? 'Create' : 'Update' }}
							</button>
						</div>
					</div>
				</form>
				

			</div>
		</div>
	</div>
</div>


<div class="row-fluid">
   @include('layouts.partials._datatable', ['route'=>'subscribers.index', 'parent'=>'list_id', 'parent_id'=>$list->id, 'limit'=>100])
</div>

@endsection
