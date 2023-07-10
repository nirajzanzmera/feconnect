@extends('fe.layouts.app')
@section('content')
<div>
    <h1 class="page-heading">Websites - Posts</h1>
</div>
@include('fe.websites._nav')

<div class="card card-default">
    <div class="card-header">
        Create New Post
    </div>
    <div class="card-block">
        <form action="{{ route('websites.posts.store', $website->id) }}" method="POST" id="post_form">
            {!! csrf_field() !!}

            @include('fe.websites.posts._form')

            <div class="row form-group">
                <button data-action="create" type="button" class="btn btn-success" id="submit_btn">
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
