@extends('fe.layouts.app')
<link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"
        xmlns="http://www.w3.org/1999/html"/>
@section('content')
<div>    
    <h1 class="page-heading">Templates</h1>
</div>

@include('fe.websites._nav')
   
<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6 col-sm-4 col-md-5 px-0 px-xl-2">
                        <h4 class="card-title">
                            New Web Page Templates
                        </h4>
                        <p class="card-subtitle">Use a template to create a new web page.</p>
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
                    @if (!empty($templates))
                        @foreach($templates as $template)
                            @include('fe.websites.templates._thumb')
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('css')
<style type="text/css">
    .tmp-thumb {
        padding: 15px; 
        margin-bottom: 25px; 
        background: rgb(102,102,102,0.1); 
        text-align: center;
    }
    .tmp-title {
        padding:15px;
    }
</style>
@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.tmp_delete').on('click', function(){
        var url = $(this).data('url');
        var id = $(this).data('id');
        swal({
            title: "Are you sure?",
            text: "Are you sure that you want to DELETE this Template?",
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
                        $('#tmp_' + id).remove();
                    }
                });
            }
        });
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


</script>
    <script type="text/javascript">
        $(document).ready(function(){
            Fancybox.bind(".fancybox", {
                Image: {
                    fit: 'contain_w',
                },
            });
        })
    </script>
@endsection
