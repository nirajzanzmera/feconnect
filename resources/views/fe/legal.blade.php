@extends('fe.layouts.app')
@section('content')
<div>
    <h1 class="page-heading">Legal</h1>
</div>
@include('fe.layouts._breadcrumbs')
<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Documents
            </div>
            <div class="card-block">
                <p>
                    <a href="{{ asset('files/dataczar_universal_terms_of_service.pdf') }}" target="_blank" class="btn btn-default btn-large">
                        <span class="fa fa-file"></span>
                        Dataczar Universal Terms of Service
                    </a> 
                    <br />
                    <br />
                    <a href="{{ asset('files/dataczar_privacy_policy.pdf') }}" target="_blank" class="btn btn-default btn-large">
                        <span class="fa fa-file"></span>
                        Dataczar Privacy Policy
                    </a> 
                    <br />
                    <br />
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
