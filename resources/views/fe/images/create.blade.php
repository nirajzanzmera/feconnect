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
                <form action="{{route('images.store')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group pad">
                                    <label for="exampleInputEmail1">Image(s):</label>
                                    <input type="file"  class="form-control" id="image"  name="image[]" multiple>
                                    @if($errors->count() > 0)
                                    <span class="help-block">
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                            @endforeach
                                        </div>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <br> <br>
                    <br> <br>
                    <div class="row" style="padding-left:15px;padding-right:15px;">
                        <div class="col-md-12">
                            <button type="submit" class="btn save-btn">Save</button>
                            <a href="{{route('images.index')}}" class="btn edit-btn">Cancel</a>
                        </div>
                    </div>
                    <br/><br/>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
