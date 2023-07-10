@extends('layouts.app')
@section('content')
<div>
  <a class="btn btn-success btn-sm pull-right" style="margin-top: 22px;" href="{{ route('images.index') }}">
    <i class="fa fa-arrow-left"></i> Back
  </a>
  <h1 class="page-heading">Images</h1>
</div>
<div class="row-fluid">
  <div class="col-md-8">
    <div class="card">
      <div class="card-block">
{{ $image->path }}

              <img src="{{ $image->path }}">
            
        </div>
      </div>
    </div>
  </div>
</div>
@stop
