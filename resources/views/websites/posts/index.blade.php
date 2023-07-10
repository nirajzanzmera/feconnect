@extends('layouts.app')

@section('css')
<style>
    .results li:nth-of-type(even) {
        background:#f5f5f5;
    }
</style>
@endsection

@section('content')
@if($headless != true and $hidetitle != true)
<div>
    <h1 class="page-heading">Websites - Posts</h1>
</div>
@endif

@include('websites._nav')

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
                        <h4 class="card-title">Posts</h4>
                    </div>
                    <div class="media-right media-middle pull-right">
                        <a href="{{ route('websites.posts.create', $website) }}" class="btn btn-sm btn-success ">
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
                                                <em><a  href='{{route('websites.pages.index', ['website'=>$website])}}'>Click here to edit pages</a></em>
                                                </li>
                                            </ul>
                                            ">
                                            <i class="fa fa-btn fa-question-circle"></i>
                                </a>

                    </div>
                </div>
            </div>
            <ul class="list-group results">
                @foreach($website->posts as $post)
                <li class="list-group-item" id="post_{{ $post->id }}">
                    <div class="row" >
                        <div class="col-md-2">
                            <img src="{{ 
                                !empty($post->image) ? $post->image : 'https://via.placeholder.com/250x160?text=No+Image'
                            }}" alt="" class="img-fluid" style="max-height:160px;">
                        </div>
                        <div class="col-md-6">
                            <strong>Date:</strong> {{ $post->start_time->format('Y-m-d') }} &nbsp; <div class="label {{ $post->status == 'live' ? 'label-success' : 'label-default' }}"> {{ $post->status }}</div><br />
                            <strong>Title:</strong> {{ $post->title }} <br />
                            <strong>Description:</strong> {{ $post->description }}
                            
                            @if (!empty($post_stats[$post->id]['views']))
                            <br />    
                            <strong>Views:</strong> {{ $post_stats[$post->id]['views'] }}
                            @endif
                        </div>
                        <div class="col-md-4">
                            @rowmenu(['items' => $post->btns])@endrowmenu
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            
            

        </div>
    </div>
</div>

@endsection


@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard-polyfill/2.8.6/clipboard-polyfill.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
        $('[data-toggle="popover"]').popover({
            trigger: 'focus', 
            html: true,
        });

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
                            $('#post_' + id).remove();
                        }
                    });
                }
            });
        });


    });
</script>    
@endsection