@extends('layouts.app')
@section('content')
<div>
    <h1 class="page-heading">Websites</h1>
</div>

@include('websites._nav')

@if($errors->count() > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif
<div class="row-fluid">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Create New Website</h4>
                    </div>
                    <div class="media-right media-middle">

                    </div>
                </div>
            </div>
            <div class="card-block">
                <form action="{{ route('websites.store') }}" method="POST" id="website_form">
                    {{ csrf_field() }}

                    <fieldset class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-2 form-control-label" style="text-align:right">Name</label>
                        <div class="col-md-8">
                            <input id="name" class='form-control' name="name"
                                value="{{ old('name', !empty($website->name) ? $website->name : NULL ) }}" />
                        </div>
                        @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </fieldset>
                    <input type="hidden" name="template_id" value="218">
                    
                    <hr>

                    <div class="row form-group">
                        <div class="col-md-8 col-md-offset-2">
                            <button class="btn btn-success" type="submit" id="submit_btn">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection