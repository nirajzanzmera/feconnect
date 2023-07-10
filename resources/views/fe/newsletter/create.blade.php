@extends('fe.layouts.app')
@section('content')
<div>
    <h1 class="page-heading">Newsletter</h1>
</div>
@include('fe.campaigns._nav')
@if($errors->count() > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif
<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Newsletters</h4>
                        <p class="card-subtitle">Create newsletter using a template and your posts.</p>
                    </div>
                    <div class="media-right media-middle">

                    </div>
                </div>
            </div>
            <div class="card-block">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Step 1</h4>
                        <p class="card-subtitle">Select a Template, one of ours or one of yours.</p>
                    </div>
                </div>
            </div>

            <div class="card-block">
                <div class="media">
                    <div class="media-body">
                        <p class="card-subtitle">Our Templates</p>
                        <hr>
                        @foreach($sys_templates as $template)
                        @include('fe.newsletter._features')
                        @endforeach
                    </div>
                </div>
                <div class="media-body">
                    <div class="media-body">
                        <div class="media-body">
                            <p class="card-subtitle">Your Templates</p>
                            <hr>
                            @foreach($templates as $template)
                            @include('fe.newsletter._features')
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @endsection
