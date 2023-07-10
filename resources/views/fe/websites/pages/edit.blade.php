@extends('fe.layouts.app')

@section('content')
{{--@if($headless != true and $hidetitle != true)--}}
<div>
    <a href="{{ route('websites.pages.index', $website->id) }}" class="btn btn-default btn-sm pull-right"
        style="margin-top: 22px;">
        <i class="fa fa-arrow-left"></i> Back
    </a>
    <h1 class="page-heading">Websites - Pages</h1>
</div>
{{--@endif--}}

@include('fe.websites._nav')

<div class="row-fluid">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                Edit {{ ucwords($type ?? '') }} {{ $page->title }}
            </div>
            <div class="card-block">
                <form action="{{ route('websites.pages.update', ['website'=>$website->id, 'page'=>$page->id, 'type'=>$type]) }}"
                    method="POST" id="page_form">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}

                    @if($type=='link')
                    @include('fe.websites.pages._link_form')
                    @else
                    @include('fe.websites.pages._form')
                    @endif

                    <div class="row form-group">
                        <button type="button" class="btn btn-success" id="submit_btn" onClick="window.dirty = false;">
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