@extends('layouts.app')
@section('content')
<div>
    <a href="{{route('newsletters.index')}}" class="btn btn-default btn-sm pull-right" style="margin-top: 22px;">
        <i class="fa fa-arrow-left"></i> Back
    </a>
    <h1 class="page-heading">Newsletter - Edit</h1>
</div>
{{-- <ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li><a href="{{ route('newsletters.index') }}">Newsletter</a></li>
    <li class="active">Edit</li>
</ol> --}}
@include('campaigns._nav')
<div class="row-fluid">
    <div class="col-md-12">
        <form method="post" action="{{ empty($newsletter) ? route('newsletters.store') : route('newsletters.update', $newsletter) }}">
            {!! csrf_field() !!}
            {{ empty($newsletter) ? '' : method_field('PUT') }}
            <div class="card">
                <div class="card-block">
                    @include('newsletter._form')
                    
                    <div class="row form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">
                            <i class="fa fa-btn fa-save"></i> {{ empty($newsletter) ? 'Create' : 'Update' }}
                            </button>
                        </div>
                    </div>
                    
                </div>
            </div>
            @include('layouts.partials._editor', ['hide_templates' => true])
            <div class="card">
                <div class="card-block">
                    <div class="row form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">
                            <i class="fa fa-btn fa-save"></i> {{ empty($newsletter) ? 'Create' : 'Update' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
    </div>
</div>
@endsection
