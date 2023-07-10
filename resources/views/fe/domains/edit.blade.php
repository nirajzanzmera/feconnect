@extends('fe.layouts.app')

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
    @if(!empty($custom_nameservers) && $custom_nameservers == true)
       @include('domains.partials._nswarning')
    @else
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Hosting Summary
                    </h4>
                </div>
                @include('components.responsive_table', [
                    'header' => [
                        ['label'=>'Domain Name', 'field'=>'domain'], 
                        ['label'=>'Website', 'field'=>"destination"]
                    ],
                    'rows' => $domains
                ])
                {{-- @rtable([
                    'header' => [
                        ['label'=>'Domain Name', 'field'=>'domain'], 
                        ['label'=>'Website', 'field'=>"destination"]
                    ],
                    'rows' => $domains
                ])@endrtable --}}
                <div class="card-block card-block-light">
                    <a href="{{ route('domains.hosting.index', $domain->id) }}" class="btn btn-success" dusk="edit-hosting">Edit Hosting</a>
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
                @include('components.responsive_table', [
                    'header' => [
                        ['label'=>'Email', 'field'=>'email'],
                        ['label'=>'Forwards to', 'field'=>"destination"],
                        ['label'=>'', 'field'=>'btn', 'raw'=>true],
                    ],
                    'rows' => $boxes
                ])
                <div class="card-block card-block-light">
                    <a href="{{ route('domains.email_boxes.index', $domain->id) }}" class="btn btn-success" dusk="edit-email">Edit Email</a>
                </div>
            </div>
        </div> 
    @endif
</div>
@endsection
@section('js')


@endsection