@extends('fe.layouts.app')
@section('css')
<style>
    label {
        font-weight: bold;
    }
</style>
@endsection
@section('content')
<div>
    <h1 class="page-heading">
        Lists
        @if(count($teams) > 1)
         - {{ $team->name }}    
        @endif
    </h1>
</div>
<ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li class="active">Lists</li>
</ol>
@include('lists._nav')
<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Create a New List</div>
            <div class="card-block">@include('lists._form')</div>
        </div>
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">
                    Your Lists
                </h1>
            </div>


            <div class="card-block card-block-light" style="margin: .625rem;margin-top: 0;padding: 0;">
                <ul class="list-group">
                    <li class="list-group-item row hidden-lg-down row ">
                        <div class="col-lg-3"><strong>Name:</strong></div>
                        <div class="col-lg-2 text-lg-right"><strong>Subscribers:</strong></div>
                        <div class="col-lg-2 text-lg-right"><strong>Complaint %:</strong></div>
                        <div class="col-lg-2 text-lg-right"><strong>Status:</strong></div>
                        <div class="col-lg-3"></div>
                    </li>
                    @foreach($lists->data as $list)
                    <li class="list-group-item row" id="list_{{ $list->id }}">
                        <div class="col-xl-3 ellipsis">
                            <label class="hidden-lg-up">Name:</label>
                            {{ $list->name }}
                        </div>
                        <div class="col-xl-2 text-lg-right">
                            <label class="hidden-lg-up">Subscribers:</label>
                            <span class="count" data-list_id="{{ $list->id }}">...</span>
                        </div>
                        <div class="col-xl-2 text-lg-right">
                            <label class="hidden-lg-up">Complaint %:</label>
                            {{ sprintf("%0.2f",($list->data->complaint_rate ?? 0) * 100.0) }}%
                        </div>
                        <div class="col-xl-2 text-lg-right">
                            <label class="hidden-lg-up">Status:</label>
                            @if($default_list_id == $list->id)
                            <div class="label label-success">DEFAULT</div>
                            @endif
                            <div class="label label-info">{{ $list->status }}</div>
                        </div>
                        <div class="col-xl-3">
                            <div class="btn-group pull-right ">
                                <a href="{{ route('lists.subscribers', $list->id) }}" title="Manage" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <div class="btn-group">
                                    <div class="dropdown show">
                                        <a class="btn btn-sm btn-default dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-bars"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                            <a href="{{ route('lists.subscribers', $list->id) }}" title="Manage" class="dropdown-item">
                                                <i class="fa fa-edit"></i> Manage
                                            </a>
                                            <button class="dropdown-item list-delete" title="Delete..." data-id="{{ $list->id }}"
                                                data-url="{{route('lists.destroy', $list->id)}}">
                                                <i class="fa fa-trash-o"></i> Delete...
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.count').each(function(){
        var list_id = $(this).data('list_id');
        updateListCount(this, list_id);
    });
    function updateListCount(target, list_id) {
        $(target).html('loading...');
        $.get('{{ route('list.get_count') }}?id=' + list_id, function(data) {
            $(target).html(data);
        });
    }

    $('.list-delete').on('click', function(){
        var url = $(this).data('url');
        var id = $(this).data('id');
        swal({
            title: "Are you sure?",
            text: "Are you sure that you want to DELETE this list?",
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
                        $('#list_' + id).remove();
                    }
                });
            }
        });
    });
});    
</script>
@endsection
