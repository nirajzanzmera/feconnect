@extends('fe.layouts.app')
@section('css')
<link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"
        xmlns="http://www.w3.org/1999/html"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />

<style>
#url {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
    .bootstrap-tagsinput .tag {
        background: #116AFF;
        padding: 4px;
        font-size: 14px;
    }

</style>
@endsection
@section('content')
@include('fe.content._nav')

<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <div class="card-title">File: {{pathinfo($file)['filename']}}</div>
                    </div>
                </div>
            </div> 
            <div class="card-block card-block-light">
                <div class="row">
                    <div class="col-md-6 center"><br/>
                        <a href="{{$file}}" id="file_path">
                            <h1><i class="fa fa-file"></i></h1>
                            {{basename($file)}}
                        </a>
                        <img src="{{$file}}" id="image" style="display: none;">
                    </div>
                    <div class="col-md-6">
                        <div id="properties">
                            <h4 class="font-weight-bolder">Properties</h4>
                            <div class="d-flex">
                                <span>File name:</span>
                                <span class="ml-2" style="overflow-wrap:anywhere;">{{basename($file)}}</span>
                            </div>
                            <div class="d-flex">
                                <span style="width: 120px;">File URL:</span>
                                <span id="url" class="ml-2" style="overflow-wrap:anywhere; white-space:unset; overflow:unset;">
                                    {{$file}}
                                </span>
                            </div>
                            {{--<div class="d-flex">--}}
                                {{--<span>File Size:</span>--}}
                                {{--<span id="dimension" class="ml-2"></span>--}}
                            {{--</div>--}}
                            <div class="d-flex">
                                <span>File Format:</span>
                                <span id="format" class="ml-2"><?php echo $ext = pathinfo($file, PATHINFO_EXTENSION); ?></span>
                            </div>
                        </div>
                            <div class="btn-group pull-right">
                            {{--<div class="btn-group">--}}
                                {{--<a target="_blank" href="https://www.zazzle.com/cr/buffet/at-238110888125061946?rf=238110888125061946&sr=250047085689669643&t__useQpc=false&ed=true&t__smart=false&continueUrl=https%3A%2F%2Fwww.zazzle.com%2Fstore%2Fdataczar&tc=&ic=&t_image1_iid={{urlencode($file)}}">--}}
                                    {{--<div class="parent">--}}
                                        {{--<img class="image1" src="{{ url('img/canvas2-white.png') }}" />--}}
                                        {{--<img class="image2" src="{{$file}}" width="20" style="top: 50px; left: 20px;" />--}}
                                        {{--<img class="image2" src="{{$file}}" width="40" style="top: 40px; left: 50px;" />--}}
                                        {{--<img class="image2" src="{{$file}}" width="20" style="top: 50px; left: 100px;" />--}}
                                    {{--</div>--}}
                                    {{--<button class=" btn btn-success btn-sm" >--}}
                                        {{--Buy Merchandise<br>with This Image--}}
                                    {{--</button>--}}
                                {{--</a>--}}
                            {{--</div>--}}

                            <a href="#" class="btn btn-info copy " data-link="{{$file}}">
                                <i class="fa fa-btn fa-copy "></i>
                            </a>
                            <a class="btn btn-primary" href="{{$file}}">
                                <i class="fa fa-btn fa-download  "></i>
                            </a>
                            <div class="btn-group">
                                <div class="dropdown show">
                                    <a class="btn  btn-default dropdown-toggle" href="#" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuLink">
                                        <a href="#" class="dropdown-item copy " data-link="{{$file}}">
                                            <i class="fa fa-btn fa-copy "></i>
                                            Copy Link
                                        </a>
                                        <a class="dropdown-item" href="{{$file}}">
                                            <i class="fa fa-btn fa-download  "></i>
                                            View File
                                        </a>
                                        <a class="dropdown-item" href="#"><i class="fa fa-trash"></i> Delete File..</a>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <style>
                            .parent {
                                position: relative;
                                top: 0;
                                left: 0;
                            }
                            .image1 {
                                position: relative;
                                top: 0;
                                left: 0;
                                border: 1px #C9C9C9 solid;
                            }
                            .image2 {
                                position: absolute;
                                top: 15px;
                                left: 10px;
                                border: 1px #C9C9C9 solid;
                            }
                        </style>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard-polyfill/2.8.6/clipboard-polyfill.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous"></script>

<script type="text/javascript">

    $(document).ready(function(){

        var tagInputEle = $('#tags-input');
        tagInputEle.tagsinput();
        //tagInputEle.tagsinput('add', 'Jakarta');
        //tagInputEle.tagsinput('add', 'Bogor');
        //tagInputEle.tagsinput('add', 'Bandung');

        $('.copy').on('click', function(e) {
            e.preventDefault();
            var link = $(this).data('link');
            clipboard.writeText(link);
            alert('Copied to Clipboard');
        });
        Fancybox.bind(".fancybox", {
            Image: {
                fit: 'contain_w',
            },
            // on : {
            //     ready : (fancybox) => {
            //         console.log(`fancybox #${fancybox.id} is ready!`);
            //     }
            // }
        });

    });
</script>
@endsection