@extends('layouts.app')



@section('content')
@if($headless != true and $hidetitle != true)
<div>
    <h1 class="page-heading">Websites</h1>
</div>
@endif

@include('websites._nav')

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
                    <div class="media-body media-middle">
                        <h4 class="card-title">{{ $website->name }} - Settings</h4>
                    </div>

                </div>
            </div>
            <div class="card-block">
                <form action="{{ route('websites.update', $website) }}" method="POST" id="website_form">
                <div class="row">
              
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    @include('websites._form')

                    <div class="row form-group">
                        <div class="col-md-8 col-md-offset-2">
                            <button class="btn btn-success" type="submit" id="submit_btn">Update</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js2')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style type="text/css">
    .placeholder {
        height: 50px;
    }
</style>

<script>
    $(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});
</script>
@endsection
