@extends('fe.layouts.app')
@section('content')
    {{-- @if($headless != true and $hidetitle != true) --}}
    <div>
        <h1 class="page-heading">
            Funds
        </h1>
    </div>
    {{-- @endif --}}
    @include('fe.billing._nav')

    @if($errors->count() > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- CONTENT START --}}

    {{-- CONTENT END --}}

@endsection

@section('js')
    <link rel="stylesheet" type="text/css"
          href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.standalone.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover({
                trigger: 'focus',
                html: true,
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard-polyfill/2.8.6/clipboard-polyfill.js"></script>

@endsection