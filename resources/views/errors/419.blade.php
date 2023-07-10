@extends('layouts.error')


@section('content')

<div class="flex-center position-ref full-height">
    <div class="code">
        419 
    </div>
    <div class="message" style="padding: 10px;">
        Unknown Status 
    </div>
    <div class="text-center" style="position:absolute; margin-top:200px;">
        <p>Something went wrong. <br />Checkout our help Center or head back to Home.</p>
        <a href="https://help.dataczar.com/" class="btn btn-default">
            <i class="fa fa-question-circle"></i>
            Help
        </a>
        <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="fa fa-chevron-left"></i>
            Home
        </a>
    </div>
</div>


@endsection
