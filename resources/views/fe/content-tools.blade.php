@extends('fe.layouts.app')
@section('content')

    @include('fe.content._nav')
    <div class="row-fluid">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">{{ isset($newcontent->title)?$newcontent->title:'' }}</h1>
                </div>
                <div class="card-block card-block-light">
                    {!! isset($newcontent->content)?$newcontent->content: ''!!}
                </div>
            </div>
        </div>
    </div>


@endsection

@section('css')
    <style type="text/css">
    </style>
@endsection

@section('js')
    @include('fe.layouts._popover')
@endsection