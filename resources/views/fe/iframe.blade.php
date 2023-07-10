@extends('fe.layouts.app')
@section('content')
<iframe 
    src="https://s3-us-west-2.amazonaws.com/jdat/_public/tmp/ux-connect/alternate_login.html"
    frameBorder="0"
    style="top:0; left:0; bottom:0; right:0; width:-webkit-fill-available; height:100vh;margin-left:-1.25rem;margin-right:-1.25rem;"
    >
    Your browser doesn't support iFrames.
</iframe>
@endsection

@section('css')
<style type="text/css">
</style>
@endsection

@section('js')
@include('fe.layouts._popover')
@endsection