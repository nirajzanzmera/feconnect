@extends('layouts.app')

@section('css')
<style>
    .form-control-label {
        font-weight: bold;
    }
</style>
@endsection
@section('content')

@include('domains.partials._nav')
<div class="row-fluid">
    @if($custom_nameservers == true)
       @include('domains.partials._nswarning')
    @else
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Hosting Summary
                    </h4>
                </div>
                @rtable([
                    'header' => [
                        ['label'=>'Domain Name', 'field'=>'domain'], 
                        ['label'=>'Website', 'field'=>"destination"]
                    ],
                    'rows' => $domains
                ])@endrtable
                <div class="card-block card-block-light">
                    <a href="{{ route('domains.hosting.index', $domain) }}" class="btn btn-success" dusk="edit-hosting">Edit Hosting</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Email Summary
                    </h4>
                </div>
                @rtable([
                    'header' => [
                        ['label'=>'Email', 'field'=>'email'],
                        ['label'=>'Forwards to', 'field'=>"destination"],
                        ['label'=>'', 'field'=>'btn', 'raw'=>true],
                    ],
                    'rows' => $boxes
                ])@endrtable
                <div class="card-block card-block-light">
                    <a href="{{ route('domains.email_boxes.index', $domain) }}" class="btn btn-success" dusk="edit-email">Edit Email</a>
                </div>
            </div>
        </div> 
    @endif
</div>
@endsection
@section('js')


@endsection