@extends('fe.layouts.app')
@section('content')

    @include('fe.education._nav')
    <div class="row-fluid">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">
                        @if(Route::currentRouteName() == 'education.ask')
                            {{ "Submit a request" }}
                        @else
                            {{ isset($newcontent->title)?$newcontent->title:'' }}
                        @endif
                    </h1>
                </div>
                <div class="card-block card-block-light">
                    @if(Route::currentRouteName() == 'education.ask')
                        {{--<iframe id="serviceFrameSend" src="https://dataczar.zendesk.com/hc/en-us/requests/new--}}{{--{{ url('/') }}/education/ask/raw--}}{{--" width="100%" height="450"--}}
                                {{--style="border: none" frameborder="0"></iframe>--}}
                        <iframe id="serviceFrameSend" src="{{ url('/') }}/education/ask/raw" width="100%" height="450"
                                style="border: none" frameborder="0"></iframe>

                    @else
                       {!! isset($newcontent->content)?$newcontent->content: ''!!}
                    @endif
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