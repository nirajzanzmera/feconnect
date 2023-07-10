@extends('layouts.app')
@section('content')
<div>    
    <h1 class="page-heading">Templates</h1>
</div>

@include('websites._nav')
   
<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Dataczar Templates</div>
           
                <div class="card-block">
                <div class="row">
                    @foreach($templates as $template)
                        @include('websites.templates._thumb')
                    @endforeach
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
</script>
@endsection
