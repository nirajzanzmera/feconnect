@extends('fe.layouts.app')
@section('content')
{{--@if($headless != true and $hidetitle != true)--}}
<div>
    <a href="{{route('websites.pages.index', $website->id)}}" class="btn btn-default btn-sm pull-right"
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
                <div class="row">
                    <div class="col-md-6">
                        Preview Page : {{ $page->title ?? '' }}
                    </div>
                    <div class="col-md-6">
                        {{--@rowmenu(['items' => $btns])@endrowmenu--}}
                    </div>
                </div>
            </div>
            <div class="card-block">
                <div class="btn-group pull-right">
                    <a class="btn btn-default" href="#" id="mobile" title="mobile"><i
                            class="sidebar-menu-icon material-icons">smartphone</i></a>
                    <a class="btn btn-default active" href="#" id="desktop" title="desktop"><i
                            class="sidebar-menu-icon material-icons">desktop_mac</i></a>
                </div>
            </div>
            <div class="card-block">
                <div class="embed-responsive embed-responsive-4by3">
                   {{--<iframe id="preview-iframe" name="preview-iframe" class="embed-responsive-item" style="border: 1px solid #ddd;"--}}
                           {{--src="{{ route('websites.pages.preview', ['id'=>$website->id, 'page'=>$page->id]) }}"></iframe>--}}
                    <iframe id="preview-iframe" name="preview-iframe" class="embed-responsive-item" style="border: 1px solid #ddd;"
                           src="{{ $preview_link }}"></iframe>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard-polyfill/2.8.6/clipboard-polyfill.js"></script>
<script>
    $(document).ready(function(){
        $('#mobile').click( function(e) {
            e.preventDefault();
            $(this).addClass('active');
            $('#desktop').removeClass('active');
            $('#preview-iframe').animate({ width: "375px" });
        });
        $('#desktop').click( function(e) {
            e.preventDefault();
            $(this).addClass('active');
            $('#mobile').removeClass('active');
            $('#preview-iframe').animate({ width: "100%" });
        });

        $('.copy').on('click', function(e) {
            e.preventDefault();
            var link = $(this).data('link');
            clipboard.writeText(link);
            alert('Copied to Clipboard');
        });
    });
</script>
@endsection