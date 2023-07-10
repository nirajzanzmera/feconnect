@extends('fe.layouts.app')
@section('css')
<link
        rel="stylesheet"
        xmlns="http://www.w3.org/1999/html"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
<style>

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
                        <div class="card-title">Image: {{pathinfo($file)['filename']}}</div>
                    </div>
                </div>
            </div> 
            <div class="card-block card-block-light">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" id="crop-image" class="btn btn-primary btn-md mb-2">Crop</button>
                        <div id="image-display"></div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <div id="preview-image"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
{{-- <script src="https://raw.githubusercontent.com/sconsult/croppic/master/croppic.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

<script type="text/javascript">

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var resize = $('#image-display').croppie({
            enableExif: true,
            enableOrientation: true,    
            viewport: { // Default { width: 100, height: 100, type: 'square' } 
                width: 300,
                height: 300,
                type: 'square', //circle
                enableResize: true,
                enableOrientation: true,
                mouseWheelZoom: 'ctrl'

            },
            boundary: {
                width: 400,
                height: 400
            }
        });

        resize.croppie('bind',{
            url: "{{$file}}"
        });

        $('#crop-image').on('click', function (ev) {
            resize.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (img) {
                $.ajax({
                url: "{{route('images.upload')}}",
                type: "POST",
                data: {"image":img},
                success: function (data) {
                    html = '<img src="' + img + '" />';
                    $("#preview-image").html(html);
                }
                });
            });
            });

    });
</script>
@endsection