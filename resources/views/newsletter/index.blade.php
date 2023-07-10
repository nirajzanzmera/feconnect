@extends('fe.layouts.app')
@section('content')
{{--@if($headless != true and $hidetitle != true)--}}
{{--<div>--}}
    {{--<h1 class="page-heading">--}}
        {{--Newsletters--}}
        {{--@if(auth()->user()->teams->count() > 1)--}}
         {{--- {{ auth()->user()->currentTeam->name }}    --}}
        {{--@endif--}}
    {{--</h1>--}}
{{--</div>--}}
{{--@endif--}}
@include('campaigns._nav')
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
                        <h4 class="card-title">Newsletters</h4>
                        <p class="card-subtitle">Create newsletter using a template and your posts.</p>
                    </div>
                    <div class="media-right media-middle">
                        <a href="{{ route('newsletters.create') }}" class="btn btn-sm btn-success pull-right">
                            <i class="fa fa-btn fa-magic"></i>
                            Get Started...
                        </a>
                    </div>
                </div>
            </div>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Feed</th>
                            <th></th>
                        </tr>
                    </thead>
                    @foreach($newsletters as $news)
                    <tr id="news_{{ $news->id }}">
                        <td>
                            <img src="{{ $news->thumburl }}" style="max-width:50px; padding-right:5px;">
                            {{ $news->name }}
                        </td>
                        <td>
                            {{  !empty($news->feed) ? 
                                (!empty($news->feed->name) ? 
                                    'Website:'.$news->feed->name : $news->feed->url
                                ) : ''
                            }}
                        </td>
                        <td>
                            <div class="btn-group ">
                                @if($news->ad_limit > 0)
                                    <a href="{{ route('campaigns.newsletter.ads', ['news'=>$news->id]) }}" class="btn btn-sm btn-success loading" title="Create">
                                @else
                                    <a href="{{ route('campaigns.newsletter', ['news'=>$news->id]) }}" class="btn btn-sm btn-success loading" title="Create">
                                @endif
                                    <i class="fa fa-plus"></i>
                                </a>
                                <a href="{{ route('newsletters.preview', $news) }}" class="btn btn-sm btn-primary loading" title="Preview">
                                    <i class="fa fa-eye"></i>
                                </a>
                                 <div class="btn-group">
                                        <div class="dropdown show">
                                            <a class="btn btn-sm btn-default dropdown-toggle" href="" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-bars"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a href="{{ route('campaigns.newsletter', ['news'=>$news->id]) }}" class="dropdown-item" title="Create">
                                                <i class="fa fa-plus"></i> Create
                                                </a>
                                                <a href="{{ route('newsletters.preview', $news) }}" class="dropdown-item" title="Preview">
                                                <i class="fa fa-eye"></i> Preview
                                                </a>
                                                <a href="{{ route('newsletters.edit', $news) }}" class="dropdown-item" title="Edit">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <a href="{{ route('newsletters.saveAs', $news) }}" class="dropdown-item" title="Save As">
                                                    <i class="fa fa-save"></i> Save As
                                                </a>
                                                <a href="#" class="dropdown-item news-delete" data-id="{{ $news->id }}" data-url="{{ route('newsletters.destroy',$news )}}"><i class="fa fa-trash-o"></i> Delete...</a>
                                            </div>
                                        </div>
                                    </div>
                               
                            </div>

                             
                        </td>
                    </tr>
                    @endforeach
                </table>

        </div>
    </div>
</div>

@endsection


@section('js')
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.standalone.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.loading').click(function(e){
        e.preventDefault();
        $(this).html('<i class="fa fa-spinner fa-pulse"></i> loading...');
        $(this).addClass('disabled');
        window.location = $(this).attr("href");
    });

    $('.news-delete').on('click', function(){
        var url = $(this).data('url');
        var id = $(this).data('id');
        swal({
            title: "Are you sure?",
            text: "Are you sure that you want to DELETE this Newsletter?",
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
                        $('#news_' + id).remove();
                    }
                });
            }
        });
    });
});
</script>
@endsection
