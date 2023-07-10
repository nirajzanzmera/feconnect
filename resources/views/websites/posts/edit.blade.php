@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://src.dzr.io/connect/4/examples/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://src.dzr.io/connect/4/examples/css/bootstrap-timepicker.min.css">
@endsection

@section('content')
@if($headless != true and $hidetitle != true)
<div>
    <a href="{{route('websites.posts.index', $website)}}" class="btn btn-default btn-sm pull-right" style="margin-top: 22px;">
        <i class="fa fa-arrow-left"></i> Back
    </a>
    <h1 class="page-heading">Websites - Posts</h1>
</div>
@endif

@include('websites._nav')

<div class="row-fluid">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                Edit Post: {{ $post->title }} 
            </div>
            <div class="card-block">
                <form action="{{ route('websites.posts.update', ['website'=>$website, 'post'=>$post]) }}" method="POST" id="post_form">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}
                  
                    @include('websites.posts._form')
                    
                    <div class="row form-group">
                        <button type="button" class="btn btn-success" id="submit_btn">
                        <i class="fa fa-save"></i>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


