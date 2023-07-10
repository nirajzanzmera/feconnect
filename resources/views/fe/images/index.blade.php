@extends('layouts.guest')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css">
<style type="text/css">
.square {
    margin-right: 1rem;
    width: 70px;
    height: 70px;
}

.square:hover {
    border: 3px solid black;
}

.square > div {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
#load_list {
    position: relative;
    display: block;
    padding: .75rem 1.25rem;
    margin-bottom: -1px;
    background-color: #fff;
    border: 1px solid #e5e5e5;
}
}

html.bootstrap-layout .container-fluid {
    padding: 0;
}
</style>
@endsection
@include('images._nav')
@section('content')
<div class="card" style="margin-bottom:50px;">
    <ul class="list-group">
        <li class="list-group-item">
            <div class="media">
                <div class="media-body">
                    <h2 class="card-title">Image Manager</h2>
                </div>
                <div class="media-right">
                    <a href="" id="upload_btn" class="btn btn-success pull-right">
                        <i class="fa fa-upload"></i>
                        Upload Image
                    </a>
                </div>
            </div>
        </li>
        <div id="load_list">
            <li class="list-group-item">
                <i class="fa fa-spinner fa-pulse"></i> Loading Images...
            </li>
        </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){ 
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var field_name = '{{ $field_name }}';
    var win = '{{ $field_name }}';
    window.SetUrl = function (items) {
        window.close();
    };
    load_list();
    function load_list(dir='', field_name='') {
        $('#load_list').html('<i class="fa fa-spinner fa-pulse"></i> Loading Images...');
        $.get('{{ route('images.list') }}?dir='+dir+'&field_name'+field_name, function(data) { 
            $('#load_list').html(data);
        });
    }

    $(document).on('click', '.folder', function(e){
        e.preventDefault();
        var dir = $(this).data('dir');
        var field_name = $(this).data('field_name');
       load_list(dir, field_name);
    });


    $(document).on('click', '.select', function(e){
        e.preventDefault();
        var url = $(this).data('url');
        if(field_name !== '') {
            use(url, field_name);
        }
        if(window.opener !== null) {
            doittoit(url);
        } else {
            window.open(url, 'Preview', 'width=1000,height=600'); 
        }
    });

    function use(url, field_name) {
        parent.document.getElementById(field_name).value = url;
        if(typeof parent.tinyMCE !== "undefined") {
            parent.tinyMCE.activeEditor.windowManager.close();
        }
        if(typeof parent.$.fn.colorbox !== "undefined") {
            parent.$.fn.colorbox.close();
        }
    }

    var promises = [];
    $(document).on('click', '#upload_btn', function(e) {
        e.preventDefault();
        swal({
            confirmButtonText: '<i class="fa fa-upload"></i> Upload',
            title: 'Select image',
            html: '<input type="file" name="images[]" id="images_input" accept="image/*" multiple="multiple" class="form-control" placeholder="">',
            
        }).then(function(){
            var images = $('#images_input').prop("files");
            $.each(images, function(i, value) {
                var data = new FormData();
                //data.append('images[]', value);
                var file = value;

                //get sig
                $.get('/upload/signed?type=' + file.type + '&folder={{ $folder }}&sig={{ $sig }}&pub=true&content_type='+file.type+'&name='+file.name, function(json){

                    $.each(json.additionalData, function(key, value) {
                        data.append(key, value);
                    });
                    /*data.append('Content-Type', file.type);*/ 
                    data.append('file', file); //add file last

                    var filename = (json.name == '${filename}') ? file.name : json.name;

                    promise = $.ajax({
                        url: json.attributes.action,
                        type: json.attributes.method,
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data, textStatus, request)
                        {
                            $.get('{{ route('images.event') }}/?path={{ $folder }}/' + json.name);
                            load_list();
                        },
                    });
                });
            }); // end $each
        });
    });
});

</script>
@endsection
