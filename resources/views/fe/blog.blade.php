@extends('fe.layouts.app')
@section('css')
<style type="text/css">
.material-icons.green {
    color: green;
}
.feed-image img{
    max-height:300px; 
    max-width:100%; 
    width: auto; 
    padding-right:25px; 
    padding-bottom:5px
}
</style>
@endsection

@section('content')
{{--@if($headless != true and $hidetitle != true)--}}
<div>
    <h1 class="page-heading">
        Blog - {{ $post->title ?? ''}}
    </h1>

</div>
{{--@endif--}}
@if(!isset($hidebreadcrumbs) || (isset($hidebreadcrumbs) && $hidebreadcrumbs != true))
    @include('fe.layouts._breadcrumbs')
@endif
{{--@include('layouts.partials._breadcrumbs')--}}


@if(!empty($post))
<div class="card" style="min-height:350px;">
    <div class="card-body">
        @if(!empty($post->image))
        <div class="center">
        <img style="max-height:300px; max-width:100%; width: auto; " src="{{ $post->image ?? '' }}" alt="{{ $post->title ?? '' }}">
        </div>
        @endif
        <div class="card-block" >

            <h1 class="title">{{ $post->title ?? '' }}</h1>
            {!! $post->content ?? '' !!}
            <p class="mb-0"><small class="text-muted"><i>Posted {{substr($post->created_at ??'',0,10)}}</i></small></p>
        </div>
    </div>
</div>
{{--
<div class="card">
    <div class="card-block">
        <PRE>{!!json_encode($post??'',JSON_PRETTY_PRINT)!!}</PRE>
    </div>
</div>
--}}
@endif


<div id="feeds" class="card-columns"></div>

@endsection

@section('js')
<script>
$.ajax({url: "{{ route('blog.data') }}",
    success: function(result){
        var data = "";
        var cnt = 1;
        var tot =1;
        var post = '';

        @if(!empty($post))
            post = '{{ $post->id }}';
        @endif

        result.forEach(function(val, index) {
            //if(cnt++ > 10) return false;
            var url = '{{ url('blog/:id/:title') }}';
            url = url.replace(':id', encodeURIComponent(val['id']));
            url = url.replace(':title', encodeURIComponent(val['title']));

            if (post != val['id']){
                data +=
                        '<div id="l_'+tot+'" class="child item">' +
                        '<div class="content">' +
                        '<div class="card">'+
                        '<div class="card-header">'+
                        '<h4 class="card-title row">'+
                        '<div class="col-12">'+
                        val['title']+
                        '</div>'+
                        '</h4>'+
                        '</div>'+
                        '<ul class="list-group" style="margin: 0;margin-top: 0;padding: 0;">'+
                        '<li class="list-group-item">'+
                        '<div class="row">'+
                        '<div class="col-lg-12">'+
                        '<p class="mb-0 feed-image center">'+
                        '<a type="submit" href="'+url+'" title="'+val['title']+'">'+
                        (val['image'] ? '<img class="float-left" src="' + val['image'] + '">' : '')+
                        '</a>'+
                        '</p><p class="mb-0">'+
                        strip(val['content']).substring(0,500)+'...</p>'+
                        '<p class="mb-0"><small class="text-muted"><i>Posted '+val['start_time']['date'].substring(0,10)+'</i></small></p>'+
                        '</div>'+
                        '</div>'+
                        '</li>'+
                        '<li class="list-group-item center">'+
                        '<a type="submit" href="'+url+'" class="btn btn-default" title="'+val['title']+'"> See More</a>'+
                        '</li>'+
                        '</ul>'+
                        '</div></div></div>';
                tot++;
            }
        });


        $("#feeds").html(data);
    }
});

function strip(html)
{
   var tmp = document.implementation.createHTMLDocument("New").body;
   tmp.innerHTML = html;
   return tmp.textContent || tmp.innerText || "";
}

</script>
@endsection
