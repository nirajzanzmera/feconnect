@extends('fe.layouts.app')
@section('css')
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<style>
    label {
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<h1 class="page-heading">
        Email Templates
    </h1>
@include('campaigns._nav')

<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">User Templates</h4>
                        <p class="card-subtitle">Templates used for creating emails</p>
                    </div>
                    <div class="media-right media-middle">
                        <a class="btn btn-success btn-sm" href="{{route('emails.templates.create')}}">
                            <i class="fa fa-plus"></i> New Template
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    @foreach ($templates as $key => $template)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <div class="tmp-thumb">

                                <a href="{{route('templates.preview', $template->id)}}" title="Preview">
                                    <img src="https://dataczar-public.s3.us-west-2.amazonaws.com/{{$template->thumb}}" class="img img-thumbnail" style="background:white">
                                </a>
            
                                <h5 class="tmp-title">{{$template->name}}</h5>
                                <div>
                                    <a href="{{route('campaigns.create')}}?template={{$template->id}}" class="btn btn-sm btn-success" title="Create Email from Template">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <a href="{{route('templates.edit', $template->id)}}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <div class="btn-group">
                                        <div class="dropdown show">
                                            <a class="btn btn-sm btn-default dropdown-toggle" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-bars"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a href="{{route('campaigns.create')}}?template={{$template->id}}" class="dropdown-item" title="Create Email from Template">
                                                    <i class="fa fa-plus"></i>
                                                    Create Email
                                                </a>

                                                <a href="{{route('templates.preview', $template->id)}}" class="dropdown-item" title="Preview">
                                                    <i class="fa fa-eye"></i> Preview
                                                </a>
                                                <a href="{{route('templates.edit', $template->id)}}" class="dropdown-item" title="Edit">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <a href="#" class="dropdown-item tmp_delete" data-id="{{$template->id}}" data-url="{{route('templates.delete', $template->id)}}"><i class="fa fa-trash-o"></i>
                                                    Delete....
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6 col-sm-4 col-md-5 px-0 px-xl-2">
                        Dataczar Templates
                    </div>
                    <div class="col-6 col-sm-8 col-md-7 pr-0">
                        <div class="d-flex justify-content-end">
                            <form id="search_form" action="#" method="post" class="d-flex justify-content-end">
                                <input type="text" class="form-control search-flilter" placeholder="Search">
                                <button class="btn btn-sm btn-secondary" title="Search">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="card-block">
                <div class="row">
                    @foreach ($sys_templates as $key => $sys_template)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 items">
                            <div class="tmp-thumb center">
                        
                                <a href="{{route('templates.sys_preview', $sys_template->id)}}" title="Preview">
                                    <img src="{{(
                                                    strpos($sys_template->thumb,'http') === false ? 
                                                    'https://dataczar-public.s3.us-west-2.amazonaws.com/' : 
                                                    ''
                                                ).$sys_template->thumb}}" 
                                                class="img img-thumbnail" style="background:white">
                                </a>
                                
                                <h5 class="tmp-title">{{$sys_template->name}}</h5>
                                <div style="padding-bottom:20px;">
                                    <a href="{{route('campaigns.create')}}?template={{$sys_template->id}}" class="btn btn-sm btn-success" title="Create Email from Template">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <div class="btn-group ">
                                        <div class="dropdown show">
                                            <a class="btn btn-sm btn-default dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-bars"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a href="{{route('campaigns.create')}}?template={{$sys_template->id}}" class="dropdown-item" title="Create Email from Template">
                                                    <i class="fa fa-plus"></i>
                                                    Create Email
                                                </a>
                        
                                            </div>
                                        </div>
                                    </div>
                        
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<link rel="stylesheet" type="text/css"
    href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.standalone.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#search_form').on('submit', function(e) {
        e.preventDefault();
        let search_val = $('.search-flilter').val();

        search_val = $.trim(search_val);
        search_val = search_val.toLowerCase();
        
        if (search_val.length != 0) {
            setTimeout(() => {
                $('.tmp-title').each(function() {
                   let text = $(this).text();
                   let div = $(this).closest('.items');
                    if (text.toLowerCase().indexOf(search_val) != -1) {
                        div.show();
                    } else {
                        div.hide();
                    }
                });
            }, 1000);
        } else if(search_val.length == 0) {
            $('.items').show();
        }
    });
    
     $('.camp-publish').on('click', function(){
        var url = $(this).data('url');
        var id = $(this).data('id');
        swal({
            title: "Are you sure?",
            text: "Are you sure that you want to Schedule this email blast?",
            icon: "warning",
            buttons: [true, 'Publish'],
        })
        .then(willPublish => {
            if (willPublish) {
                window.location = url;
            }
        });
    });
    $('.camp-delete').on('click', function(){
        var url = $(this).data('url');
        var id = $(this).data('id');
        swal({
            title: "Are you sure?",
            text: "Are you sure that you want to DELETE this email blast?",
            icon: "warning",
            dangerMode: true,
            buttons: [true, 'DELETE'],
        })
        .then(willDelete => {
            if (willDelete) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    success: function(result) {
                        $('#camp_' + id).remove();
                    }
                });
            }
        });
    });
    
    $('.date').datepicker({
        multidate: true,
        format: 'yyyy-mm-dd',
    });
    //readonly!
    $('.datepicker-days').click(function(event) {
        event.preventDefault();
        event.stopPropagation();
    });
});
</script>
@endsection
