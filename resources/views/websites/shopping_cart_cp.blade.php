@extends('layouts.app')

@section('content')
<div>
    <h1 class="page-heading">Websites - Shopping Cart</h1>
</div>

@include('websites._nav')

@if($errors->count() > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif

<div class="card card-block">
    <h1>Sample of Ecwid control panel embedding</h1>
    <div id="wrap">
        <iframe
            seamless
            id="ecwid-frame"
            frameborder="0"
            width="100%"
            height="700"
            scrolling="no"
            src="{{$ssolink}}"
            >
        </iframe>
    </div>
</div>

@endsection
@section('js')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
    //<![CDATA[ 
        window.onload=function(){ // Create IE + others compatible event handler 
            var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
            var eventer = window[eventMethod];
            var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message"; // Listen to message from child window 
            eventer(messageEvent,function(e) { $('#ecwid-frame').css('height', e.data.height + 'px'); },false); 
            $(document).ready(function(){ 
                $('#ecwid-frame').css('height', '700px'); 
                $('#ecwid-frame').attr('src', 'https://my.ecwid.com/cp/CP.html?inline');
            }); 
        }//]]>
    </script>

@endsection