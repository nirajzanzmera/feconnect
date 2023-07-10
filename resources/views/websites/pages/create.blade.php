@extends('layouts.app')
@section('content')
<div>
    <a href="{{route('websites.pages.index', $website)}}" class="btn btn-default btn-sm pull-right"
        style="margin-top: 22px;">
        <i class="fa fa-arrow-left"></i> Back
    </a>
    <h1 class="page-heading">Websites - Pages</h1>
</div>

@include('websites._nav')

<div class="row-fluid">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                Create New Page
            </div>
            <div class="card-block">
                <form action="{{ route('websites.pages.store', ['website'=>$website, 'type'=>$type]) }}" method="POST" id="page_form">
                    {!! csrf_field() !!}

                    @if($type=='link')
                    @include('websites.pages._link_form')
                    @else
                    @include('websites.pages._form')
                    @endif

                    <div class="row form-group">
                        <button type="button" class="btn btn-success" id="submit_btn">
                            <i class="fa fa-save"></i>
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
