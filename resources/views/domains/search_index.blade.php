@extends('layouts.app')
@section('content')
@include('domains._nav')
<div class="row-fluid">

    <div class="card">
        <div class="card-header">
            <div class="media">
                <div class="media-body">
                    <h4 class="card-title pull-left">Register Your Domain</h4>
                </div>
            </div>
        </div>
        
        @include('domains.partials._search')
    </div>
<!-- end col-xl-6 -->
</div>
@endsection
@section('js')
<link rel="stylesheet" type="text/css"
    href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.standalone.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection
