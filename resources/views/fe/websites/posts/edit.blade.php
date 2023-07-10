@extends('fe.layouts.app')

@section('css')
    <link rel="stylesheet" href="https://src.dzr.io/connect/4/examples/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://src.dzr.io/connect/4/examples/css/bootstrap-timepicker.min.css">
@endsection

@section('content')
@if((!empty($headless) and $headless != true) and (!empty($hidetitle) and $hidetitle != true))
<div>
    <a href="{{route('websites.posts.index', $website)}}" class="btn btn-default btn-sm pull-right" style="margin-top: 22px;">
        <i class="fa fa-arrow-left"></i> Back
    </a>
    <h1 class="page-heading">Websites - Posts</h1>
</div>
@endif

@include('fe.websites._nav')

<div class="row-fluid">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                Edit Post: {{ $post->title }} 
            </div>
            <div class="card-block">
                <form action="{{ route('websites.posts.update', ['website'=>$website->id, 'post'=>$post->id]) }}" method="POST" id="post_form">
                    {!! csrf_field() !!}
                    {{-- {{ method_field('PUT') }} --}}
                    
                    @include('fe.websites.posts._form')
                    
                    <div class="row form-group">
                        <button data-action="edit" type="button" class="btn btn-success" id="submit_btn">
                        <i class="fa fa-save"></i>
                            Update
                        </button>
                    </div>
                    <div id="successMessage" style="display:none" class="alert alert-success">
                        Post updated
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


