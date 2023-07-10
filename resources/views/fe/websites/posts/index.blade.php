@extends('fe.layouts.app')



@section('css')
    {{--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">--}}
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <style>
    .results li:nth-of-type(even) {
        background:#f5f5f5;
    }
        .row{ width: 100% !important;}

    div.dataTables_wrapper div.dataTables_paginate {
        margin: 0;
        white-space: nowrap;
        text-align: right;
    }
    .pagination {
        display: inline-block;
        padding-left: 0;
        margin: 20px 0;
        border-radius: 4px;
    }
    .pagination > li {
        display: inline;
    }
    .pagination > li:first-child > a, .pagination > li:first-child > span {
        margin-left: 0;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }
    .pagination > .disabled > a, .pagination > .disabled > a:focus, .pagination > .disabled > a:hover, .pagination > .disabled > span, .pagination > .disabled > span:focus, .pagination > .disabled > span:hover {
        color: #777;
        cursor: not-allowed;
        background-color: #fff;
        border-color: #ddd;
    }
    .pagination > li > a, .pagination > li > span {
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        color: #337ab7;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
        border-top-color: rgb(221, 221, 221);
        border-right-color: rgb(221, 221, 221);
        border-bottom-color: rgb(221, 221, 221);
        border-left-color: rgb(221, 221, 221);
    }

    .pagination > .active > a, .pagination > .active > a:focus, .pagination > .active > a:hover, .pagination > .active > span, .pagination > .active > span:focus, .pagination > .active > span:hover {
        z-index: 3;
        color: #fff;
        cursor: default;
        background-color: #337ab7;
        border-color: #337ab7;
    }
    .pagination > li > a, .pagination > li > span {
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        color: #337ab7;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
        border-top-color: rgb(221, 221, 221);
        border-right-color: rgb(221, 221, 221);
        border-bottom-color: rgb(221, 221, 221);
        border-left-color: rgb(221, 221, 221);
    }
    div.dataTables_wrapper div.dataTables_info{ padding-left: 15px;}
    .dataTables_length{text-align: left;
        float: left;
        padding-left: 15px;
        padding-top: 5px; }
    .dataTables_filter{
        float: right;

        padding-top: 5px;
    }

    html.bootstrap-layout body{
    overflow: visible;
    }
    .dropdown-backdrop{ position: unset !important;}
</style>
@endsection

@section('content')
{{-- @if($headless != true and $hidetitle != true) --}}
<div>
    <h1 class="page-heading">Websites - Posts</h1>
</div>
{{-- @endif --}}

@include('fe.websites._nav')

@if($errors->count() > 0)
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">
                            Posts
                        </h4>
                    </div>
                    <div class="media-right media-middle pull-right d-flex">
                        <a href="{{ route('websites.posts.create', $website->id) }}" class="btn btn-sm btn-success ">
                            <i class="fa fa-btn fa-plus"></i>
                            Create New
                        </a>
                        <a class="btn btn-xs q-mark pull-right " tabindex="0" data-toggle="popover" data-placement="left"
                            title="What are Pages and Posts?"
                            data-content="
                            <ul>
                                <li>
                                    <strong>Pages</strong> are the permanent parts of your website. They appear in menus and can include a feed of posts on them.
                                </li>
                                <li>
                                    <strong>Posts</strong> are like articles you write on your website, where the newest is the most relevant. Posts appear in a feed on pages that include them.
                                </li>
                                <li>
                                    Use posts for content like news. Use pages for content you would like to display permanently in your menus.
                                </li>
                                <li>
                                <em><a  href='{{route('websites.pages.index', ['website'=>$website->id])}}'>Click here to edit pages</a></em>
                                </li>
                            </ul>
                            ">
                            <i class="fa fa-btn fa-question-circle"></i>
                        </a>
                        {{--<form id="search_form" action="#" method="post" class="d-flex justify-content-end">--}}
                            {{--<input type="text" class="form-control search-flilter" placeholder="Search">--}}
                            {{--<button class="btn btn-sm btn-secondary" title="Search">--}}
                                {{--<i class="fa fa-search"></i>--}}
                            {{--</button>--}}
                        {{--</form>--}}
                    </div>
                </div>
            </div>
            {{--<ul class="list-group results">--}}
                {{--@foreach($posts as $post)--}}

                {{--<li class="list-group-item items" id="post_{{ $post->id }}">--}}
                    {{--<div class="row" >--}}
                        {{--<div class="col-md-2">--}}
                            {{--<img src="{{--}}
                                {{--!empty($post->image) ? $post->image : 'https://via.placeholder.com/250x160?text=No+Image'--}}
                            {{--}}" alt="" class="img-fluid" style="max-height:160px;">--}}
                        {{--</div>--}}
                        {{--<div class="col-md-6">--}}
                            {{--<strong>Date:</strong> {{ \Carbon\Carbon::parse($post->start_time->date)->format('Y-m-d') }} &nbsp; <div class="label {{ $post->status == 'live' ? 'label-success' : 'label-default' }}"> {{ $post->status }}</div><br />--}}
                            {{--<strong>Title:</strong> <span class="post_title">{{ $post->title }} </span><br />--}}
                            {{--<strong>Description:</strong> <span class="post_desc">{{ !empty($post->description) ? $post->description : '' }}</span>--}}

                            {{--@if (!empty($post_stats[$post->id]['views']))--}}
                            {{--<br />--}}
                            {{--<strong>Views:</strong> {{ $post_stats[$post->id]['views'] }}--}}
                            {{--@endif--}}
                        {{--</div>--}}
                            {{--<div class="col-md-4">--}}
                                {{-- @rowmenu(['items' => $post->btns])@endrowmenu --}}
                                {{--<div class="btn-group pull-right">--}}
                                    {{--<a href="{{route('websites.posts.show', ['website'=>$website->id,'post'=>$post->id])}}" title="Preview" class="btn btn-sm btn-info ">--}}
                                        {{--<i class="fa fa-eye"></i>--}}
                                    {{--</a>--}}
                                    {{--<a href="{{route('websites.posts.edit', ['website'=>$website->id,'post'=>$post->id])}}" title="Edit" class="btn btn-sm btn-primary ">--}}
                                        {{--<i class="fa fa-edit"></i>--}}
                                    {{--</a>--}}
                                    {{--<a href="{{route('post.analytics', $post->id)}}" title="Analytics" class="btn btn-sm btn-secondary ">--}}
                                        {{--<i class="fa fa-bar-chart"></i>--}}
                                    {{--</a>--}}
                                {{--<div class="btn-group">--}}
                                    {{--<div class="dropdown show">--}}
                                        {{--<a class="btn btn-sm btn-default dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                                            {{--<i class="fa fa-bars"></i>--}}
                                        {{--</a>--}}
                                        {{--<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">--}}
                                            {{--<a href="{{route('websites.posts.show', ['website'=>$website->id,'post'=>$post->id])}}" title="Preview" class="dropdown-item ">--}}
                                                {{--<i class="fa fa-eye"></i>--}}
                                                    {{--Preview--}}
                                            {{--</a>--}}
                                            {{--<a href="{{route('websites.posts.edit', ['website'=>$website->id,'post'=>$post->id])}}" title="Edit" class="dropdown-item ">--}}
                                                {{--<i class="fa fa-edit"></i>--}}
                                                {{--Edit--}}
                                            {{--</a>--}}

                                            {{-- PLEASE WATCH THE DATA-LINK ATTRIBUTE BELOW  --}}

                                            {{--<a href="#" title="Copy Link" class="dropdown-item copy" data-link="https://www.yogurtconcoction.com/{{$post->id}}/image/index.html">--}}
                                                {{--<i class="fa fa-share"></i>--}}
                                                {{--Copy Link--}}
                                            {{--</a>--}}
                                            {{-- PLEASE WATCH THE DATA-LINK ATTRIBUTE ABOVE  --}}


                                            {{--<a href="{{route('websites.posts.edit', ['website'=>$website->id,'post'=>$post->id])}}" title="Save as new post" class="dropdown-item ">--}}
                                                {{--<i class="fa fa-clone"></i>--}}
                                                {{--Save as new post--}}
                                            {{--</a>--}}
                                            {{--<a href="{{route('post.analytics', $post->id)}}" title="Analytics" class="dropdown-item ">--}}
                                                {{--<i class="fa fa-bar-chart"></i>--}}
                                                {{--Analytics--}}
                                            {{--</a>--}}
                                            {{--<a href="" title="Delete..." class="dropdown-item delete" data-id="{{$post->id}}" data-url="{{route('websites.posts.show', ['website'=>$website->id,'post'=>$post->id])}}">--}}
                                                {{--<i class="fa fa-trash-o"></i>--}}
                                                {{--Delete...--}}
                                            {{--</a>--}}

                                        {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                            {{--</div>--}}
                    {{--</div>--}}
                {{--</li>--}}
                {{--@endforeach--}}
            {{--</ul>--}}

            @include('fe.websites.posts.table')
        </div>


    </div>
</div>

<div class="row-fluid">
    <div class="col-md-12">

            {{--@include('fe.websites.posts.table')--}}

            {{--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">--}}
            {{--<link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css" rel="stylesheet">--}}
    </div>
</div>
@endsection


@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard-polyfill/2.8.6/clipboard-polyfill.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('#example2').DataTable({
            "ordering": false,
            "drawCallback": function(settings) {
                var api = this.api();

                $('.delete').on('click', function (e) {
                    e.preventDefault();
                    var url = $(this).data('url');
                    var id = $(this).data('id');

                    swal({
                        title: "Are you sure?",
                        text: "Are you sure that you want to DELETE this Post?",
                        icon: "warning",
                        dangerMode: true,
                        buttons: [true, 'DELETE'],
                    })
                    .then(willDelete => {
                        if (willDelete) {
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                success: function (result) {
                                    // $('#post_' + id).remove();
                                    api.row( '#post_' + id ).remove().draw();
                                }
                            });
                        }
                    });
                });
            }
        });

    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.copy').on('click', function(e) {
            e.preventDefault();
            var link = $(this).data('link');
            clipboard.writeText(link);
            alert('Copied to Clipboard');
        });

        $('#search_form').on('submit', function(e) {
        e.preventDefault();
        let search_val = $('.search-flilter').val();

        search_val = $.trim(search_val);
        search_val = search_val.toLowerCase();
        
        if (search_val.length != 0) {
            setTimeout(() => {
                $('.post_title').each(function() {
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

        $('[data-toggle="popover"]').popover({
            trigger: 'focus', 
            html: true,
        });

    });
</script>    
@endsection