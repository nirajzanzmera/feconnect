@extends('layouts.app')
@section('content')
@if(Cookie::get('headless')!='true')
    @if(Cookie::get('hidetitle')!='true')
        <div>
            <a href="{{route('websites.edit', $website)}}" class="btn btn-default btn-sm pull-right" style="margin-top: 22px;">
                <i class="fa fa-arrow-left"></i> Back
            </a>
            <h1 class="page-heading">Websites - Posts</h1>
        </div>
    @endif
    @include('websites._nav')
@endif
<div class="card card-default">
    <div class="card-header">
        Create New Post
    </div>
    <div class="card-block">
        <form action="{{ route('websites.posts.store', $website) }}" method="POST" id="post_form">
            {!! csrf_field() !!}

            @include('websites.posts._form_quick')

            <div class="row form-group">
                <button type="button" class="btn btn-success" id="submit_btn">
                    <i class="fa fa-save"></i>
                    Create
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('css')
<link rel="stylesheet" href="https://src.dzr.io/connect/4/examples/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://src.dzr.io/connect/4/examples/css/bootstrap-timepicker.min.css">
@endsection
