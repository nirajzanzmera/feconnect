@extends('layouts.app')
@section('content')
@if($headless != true and $hidetitle != true)
<div>
    <h1 class="page-heading">Resume Subscription</h1>
</div>
@endif
@include('subscription._nav')
<div class="row-fluid">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Resume Subscription</h4>
                        <p class="card-subtitle"></p>
                    </div>
                    <div class="media-right media-middle">
                        

                    </div>
                </div>
            </div>
            <div class="card-block">
                <form action="{{ route('plans.resume') }}" method="POST">
                    {{ csrf_field() }}

                    <p>Please confirm Subscription Resume </p>
                    <button class="btn btn-primary" type="submit">Resume Subscription</button>
                </form> 
            </div>
            

        </div>
    </div>
</div>

@endsection


@section('js')

@endsection
