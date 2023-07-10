@extends('fe.layouts.app')
@section('content')
<div>
    <h1 class="page-heading">
        Dashboard
        @if(count($teams) > 1)
        - {{ $team->name }}
        @endif
    </h1>

</div>
{{-- WEBSITE ID HIDDEN VALUE PASS IN AJAX FUCNTION --}}
<input type="hidden" value="{{$website->id}}" name="website_id" id="website_id">
<input type="hidden" id="total_feed" value="">
{{---------------------------------------------------}}
<div class="card-columns">

    @if($datalist['todo_cnt'])
    @component('components.card')
        @slot('title')Account Setup - Next Steps @endslot
        <style type="text/css">
            .material-icons.green {
                color: green;
            }
            .feed-image img{
                width: 100%;
            }
        </style>
        <ul class="list-group">
            @foreach($datalist['todo'] as $key => $value)
                <li class="list-group-item @if($value['Status']== 'DONE')  list-group-item-success @endif">
                    <div class="media">
                        <div class="media-left media-middle">
                            <i class="material-icons md-24 @if($value['Status']== 'DONE') green @endif">@if($value['Status']== 'DONE') check_box @else check_box_outline_blank @endif</i>
                        </div>
                        <div class="media-body media-middle">
                            <strong>{{ $value['Title'] }}</strong>
                            @if($value['Status']== 'TODO')
                                <p>{{ $value['Description'] }}
                                    <br />
                                    <a href="{{ route($value['Route']) }}">{{ $value['Link_title'] }}</a>
                                </p>
                            @endif
                        </div>
                        <div class="media-right media-middle">
                            @if($value['Status']== 'TODO') TODO @else DONE @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endcomponent
    @endif


    @if(($quicklinks['quicklink_cnt'] ?? 0) > 0)
    @component('components.card')
        @slot('title')Quick Links @endslot
        <div class="list-group">
            @foreach(json_decode(json_encode($quicklinks['quicklinks']),true) as $key => $link)
            <a class="list-group-item" id="{{ $key }}_link" href="{{ $link['url'] ?? ''}}" @if(isset($link['window'])) target="_blank" @endif>
                <div class="media">
                    <div class="media-left">
                        <i class="fa {{ $link['fa'] ?? '' }}"></i>
                    </div>
                    <div class="media-body media-middle">
                        {{ $link['text'] ?? '' }}
                    </div>
                    <div class="media-right">
                        <i class="fa fa-chevron-right"></i>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @endcomponent
    @endif

    @if(!empty($pkgcds))
    @component('components.card')
        @slot('title')My eBooks @endslot
        <div class="list-group">
            @foreach($pkgcds as $item)
            <a class="list-group-item" href="{{ $item->path }}" target="_blank">
                <div class="media">
                    <div class="media-left">
                        <i class="material-icons text-muted-dark">file_download</i>
                    </div>
                    <div class="media-body media-middle">
                        {{ $item->description }}
                    </div>
                    <div class="media-right">
                        1.7MB
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @endcomponent
    @endif

    @if(!empty($website->id))
    @component('components.card')
        @slot('title')Recent Posts @endslot
        @slot('button') 
            <a class="btn btn-sm btn-secondary pull-right hidden-xs" title="Add Post" href="{{ route( 'post.quick_create', [ 'website' => $website->id ] ) }}">
                <i class="fa fa-plus"></i>
                Quick Add Post
            </a>
        @endslot
        <ul id="posts" class="list-group" style="margin: 0;margin-top: 0;padding: 0;">
    
            @foreach(json_decode(json_encode($posts ?? []),true) as $key => $post)
            @if($loop->iteration > 3)
            @break
            @endif
            <li class="list-group-item">
                <div class="row">
                    <div class="col-lg-10">
                        <img style="max-width:150px; margin-right:10px;" class="float-left" src="{{ $post['image'] }}" alt="">
                        <h4><a href="{{ route('websites.posts.edit',['website'=>$post['website_id'],'post'=>$post['id'] ]) }}">{{ $post['title'] }}</a></h4>
                        <p class=""><small>{!! substr(strip_tags($post['content']),0,100) !!}</small></p>
                        <p class="mb-0"><small><i>Posted {{ $post['created_at'] }}</i></small></p>
                        @if(isset($post['views']) && $post['views']>0)
                        <p class=""><small>
                                <b>Views: </b>{{ $post['views'] ?? '' }}
                        </small></p>
                        @endif
                    </div>
                    <div class='col-lg-2'>
                        <div class="btn-group pull-right">
                            <a href="{{ route('websites.posts.edit',['website'=>$post['website_id'],'post'=>$post['id'] ]) }}" title="Edit" class="btn btn-sm btn-primary ">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
            <li class="list-group-item center">
                <a type="submit" href="{{ route( 'websites.posts.index', [ 'website' => $website->id ] ) }}" class="btn btn-default" title="See More">
                    See More
                </a>
            </li>
        </ul>
    @endcomponent
    @endif

    @if(!empty($website->id))
    @component('components.card')
        @slot('card_id')recent_post @endslot
        @slot('title')Recent Posts (Ajax) @endslot
        @slot('button')
            <a class="btn btn-sm btn-secondary pull-right hidden-xs" title="Add Post" href="{{ route( 'post.quick_create', [ 'website' => $website->id ] ) }}">
                <i class="fa fa-plus"></i>
                Quick Add Post
            </a>
            @if( !empty($team->websites) && count($teams) > 1)
            <div class="">
                <select class="custom-select" @change="switchWebsitePosts($event)" id="">
                    @foreach ($team->websites as $website)
                        <option value="{{$website->id}}">
                            {{$website->name}}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif
        @endslot

        <div v-if="loading || posts.length == 0" class="d-flex py-5 justify-content-center align-items-center">
            <div v-if="loading" class="spinner-border"></div>
            <div v-if="!loading && recent_posts.length == 0" class="">
                No Post Found
            </div>
        </div>
        <ul
            ref="recent_post"
            class="list-group"
            style="margin: 0;margin-top: 0;padding: 0;"
            website-id = {{$website->id}}
            data-url="{{ url('get_recent_post') }}"
            post-url={{ url('websites/:website_id/posts/:id/edit') }}
            v-cloak
            >
            <li v-for="post in recent_posts" v-bind:key="post.id" class="list-group-item" v-cloak>
                <div class="row">
                    <div class="col-lg-10">
                        <img style="max-width:150px; margin-right:10px;" class="float-left" :src="post.image" :alt="post.title">
                        <h4>
                            <a :href="getPostUrl(post.id, post.website_id)">@{{post.title}}</a>
                        </h4>
                        <p class=""><small>@{{strip_tags(post.content)}}</small></p>
                        <p class="mb-0"><small><i>@{{post.created_at}}</i></small></p>
                        <p class=""><small></small></p>
                    </div>
                    <div class="col-lg-2">
                        <div class="btn-group pull-right">
                            <a :href="getPostUrl(post.id, post.website_id)" title="Edit" class="btn btn-sm btn-primary ">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            <li v-if="posts.length > 3" class="list-group-item center">
                <a type="submit" href="{{ route( 'websites.posts.index', [ 'website' => $website->id ] ) }}" class="btn btn-default" title="See More">
                    See More
                </a>
            </li>
        </ul>
    @endcomponent
    @endif

@if(count($team->websites) > 0)
    @if(! empty($user_chart))
    @component('components.card')
        @slot('title'){{ $user_chart->display_name }} @endslot
        @slot('button')
            <a class="btn btn-sm btn-secondary float-right" title="Website Analytics" href="{{ route('websites.analytics', ['website' => $website->id]) }}" id="chart_analytics_link">
                <i class="fa fa-bar-chart"></i>
            </a>
        @endslot
        {!! $user_chart->container() !!}
    @endcomponent
    @endif


    @if(!empty($behavior))
        @component('components.card')
            @slot('title') {{ $team->name }} Top Pages @endslot
            @slot('button')
                <a class="btn btn-sm btn-secondary pull-right hidden-xl-up"  style="margin-top:-3px;" title="Website Analytics" href="{{ route('websites.analytics', ['website' => $website->id]) }}">
                    <i class="fa fa-bar-chart"></i>
                </a>
            @endslot
            <ul class="list-group" style="margin: .625rem;margin-top: 0;padding: 0;">
                <li class="list-group-item row hidden-lg-down">
                    <div class="col-lg-8"><strong>Page</strong></div>
                    <div class="col-lg-2"><strong>Views</strong></div>
                    <div class="col-lg-2">
                        <a class="btn btn-sm btn-secondary pull-right"  title="Website Analytics" href="{{ route('websites.analytics', ['website' => $website->id]) }}">
                            <i class="fa fa-bar-chart"></i>
                        </a>
                    </div>
                </li>
                @foreach (json_decode(json_encode($behavior),true) as $page)
                <li class="list-group-item row ">
                    <div class="col-lg-8 ">
                        <label class="hidden-xl-up"><strong>Page: </strong></label>
                        {{ $page['page'] }}
                    </div>
                    <div class="col-lg-2 ">
                        <label class="hidden-xl-up"><strong>Views: </strong></label>
                        {{ $page['views'] }}
                    </div>
                    <div class="col-lg-2 pull-right">
                        @if (!empty($page['post_id']) || !empty($page['page_id']))
                                @if (!empty($page['post_id']))
                                <a class="btn btn-sm btn-secondary pull-right" title="Post Analytics" href="{{ route('post.analytics', ['post' => $page['post_id']]) }}">
                                @elseif (!empty($page['page_id']))
                                <a class="btn btn-sm btn-secondary pull-right" title="Page Analytics" href="{{ route('page.analytics', ['page' => $page['page_id']]) }}">
                                @endif
                                <i class="fa fa-bar-chart"></i>
                                </a>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
        @endcomponent
    @else
        @component('components.card')
            @slot('title') Getting Started with Dataczar @endslot
            <div class="row">
                <div class="col-lg-12">
                    <iframe
                            style="position: sticky; top: 0; left: 0; width: 100%; height: 100%; min-height: 240px;"
                            src="https://www.youtube.com/embed/y4d86GCJMGs?rel=0&showinfo=0"
                            frameborder="0"
                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            >
                    </iframe>
                </div>
            </div>
        @endcomponent
    @endif
    @include('fe._slider')

</div>
<link rel="stylesheet" href="{{ asset('assets/css/bricklayer/dist/bricklayer.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/bricklayer/demo.css') }}">
<style>
    @media (min-width: 544px){
        #feeds .card-columns .card {
            display: initial;
            width: 100%;
        }
    }

    #feeds img {
        max-width: 100%;
    }
    .masonry {
        display: grid;
        grid-gap: 1em; /* [1] Add some gap between rows and columns */
        grid-template-columns: 1fr 1fr; /*repeat( auto-fill, minmax( 200px, 1fr ) ); /* [2] Make columns adjust according to the available viewport */
        grid-auto-rows: max-content; /* [3] Set the height for implicitly-created row track */
    }

    .feed-image img {
        max-height: 300px;
        max-width: 100%;
        width: auto;
        padding-right: 25px;
        padding-bottom: 5px;
    }
</style>



<div id="feeds" class="card-columns"></div>
<style>
    .container {
        /*width: 100%;*/
        column-count: 2;
        column-gap: 16px;
        margin: 0px;
        padding: 0px;
    }

    .child {

        display: inline-block;
    }

    .content {
        width:100%;
        break-inside:avoid;
    }

    .placeholder {
        float: left;
    }

    .child:nth-child(odd) {
        min-height: 100px;
    }

    .child:nth-child(even) {
        min-height: 40px;
    }

</style>
<script>
//    var children = document.querySelectorAll('.child');
//
//    for(var i=0; children.length; i++){
//        children[i].addEventListener("click", function(){
//            var placeholder = this.querySelector('.placeholder');
//
//            placeholder.innerHTML += "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
//        });
//    }
</script>
{{--<div id="feeds" class="masonry">--}}
{{--
    <div class="card">
            <div class="card-header">
                <h4 class="card-title row">

                    <div class="col-6 col-sm-4 col-md-5 px-0 px-xl-2">
                        Feeds (Ajax)
                    </div>
                </h4>

            </div>
            <ul id="feeds" class="list-group" style="margin: 0;margin-top: 0;padding: 0;">
            </ul>
    </div>
--}}
{{--</div>--}}
@component('components.card')
    @slot('title') Refer a Friend @endslot
    @slot('button')
        <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" title="How The Dataczar Referral Program Works" data-content="
            <ul>
                <li>Share your personal referral code with your friends and family</li>
                <li>Any user that signs up using your referral code, upgrades and completes their free trial will then receive a $10 credit to their
                    account</li>
                <li>For each person you refer who signs up for Dataczar, upgrades and completes their free trial, you get a $10 credit to your
                    account</li>
            </ul>
            ">
            <i class="fa fa-btn fa-question-circle"></i>
        </a>
    @endslot
    <div class="card-block">
        Tell a friend to sign up with your referral code, give $10, get $10.
        Your Referral code: <strong>{{ $team->token }}</strong>
        <br />
    </div>
@endcomponent

    <div class="card-columns">
        <button data-append>APPEND</button>
        <button data-prepend>PREPEND</button>
        <button data-append-multiple>APPEND MULTIPLE</button>
    </div>


<section class="bricklayer">
</section>

@endif



{{--
<div class="card">
    <div class="card-header">
        Data <a href="#" onclick="getElementById('datablock').classList.toggle('hide')">toggle</a>
    </div>
    <div id="datablock" class="card-block hide">
        <pre>
{{json_encode($__data,JSON_PRETTY_PRINT)}}
        </pre>
    </div>
</div>
--}}
</div>
@endsection

@section('css')
<style type="text/css">
</style>
@endsection

@section('modal')
    @include('fe.interviews._modals')
@endsection

@section('js')
@include('fe.layouts._popover')
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard-polyfill/2.8.6/clipboard-polyfill.js"></script>
<script type="text/javascript">
    $(".layout-content").scroll(function() {
        //console.log($(this).scrollTop() + '/' + $(this).height());
        offset=$("#raf").offset();
        if (offset.top < $(this).height()) {
            console.log('at bottom');
        }
    });

    var pixel = 400;
    $(".layout-content").scroll(function() {
        if ($(this).scrollTop() > pixel) { // this refers to window
            //var tot_feed = $('#total_feed').value;
            //for(var i=1; i< tot_feed; i++){
//                document.getElementById('l_1').style.display="block";
//                document.getElementById('l_2').style.display="block";
            $("#l_1").fadeIn(20);
            $("#l_2").fadeIn(20);
            //}

            if(pixel>=1200){
                $("#l_3").fadeIn(20);
                $("#l_4").fadeIn(20);
            }
            if(pixel>=2000){
                $("#l_5").fadeIn(20);
                $("#l_6").fadeIn(20);
            }
            if(pixel>=2800){
                $("#l_7").fadeIn(20);
                $("#l_8").fadeIn(20);
            }
            if(pixel>=3600){
                $("#l_9").fadeIn(20);
                $("#l_10").fadeIn(20);
            }
            if(pixel>=4400){
                $("#l_11").fadeIn(20);
                $("#l_12").fadeIn(20);
            }
            if(pixel>=5200){
                $("#l_13").fadeIn(20);
                $("#l_14").fadeIn(20);
            }
            if(pixel>=6000){
                $("#l_15").fadeIn(20);
                $("#l_16").fadeIn(20);
            }
            if(pixel>=6800){
                $("#l_17").fadeIn(20);
                $("#l_18").fadeIn(20);
            }
            if(pixel>=7600){
                $("#l_19").fadeIn(20);
                $("#l_20").fadeIn(20);
            }
            if(pixel>=8400){
                $("#l_21").fadeIn(20);
                $("#l_22").fadeIn(20);
            }
            if(pixel>=9200){
                $("#l_23").fadeIn(20);
                $("#l_24").fadeIn(20);
            }
            if(pixel>=10000){
                $("#l_25").fadeIn(20);
                $("#l_26").fadeIn(20);
            }
            if(pixel>=10800){
                $("#l_27").fadeIn(20);
                $("#l_28").fadeIn(20);
            }
            if(pixel>=11600){
                $("#l_29").fadeIn(20);
                $("#l_30").fadeIn(20);
            }
            if(pixel>=12200){
                $("#l_31").fadeIn(20);
                $("#l_32").fadeIn(20);
            }
            pixel += 800;
        }
    });

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

        var html = '';

    });
    /* GET FEEDS AND POST USING AJAX CALL */

    {{--$.ajax(--}}
        {{--{url: "{{ route('feed.rss') }}",--}}
            {{--success: function(result)--}}
            {{--{--}}
                {{--var data = "";--}}
                {{--var cnt = 1;--}}
                {{--var tot =1;--}}
                {{--result.forEach(function(val, index) {--}}
                    {{--//if(cnt++ > 10) return false;--}}
                    {{--var url = '{{ url('automation/feeds/:id/edit') }}';--}}
                    {{--url = url.replace(':id', cnt);--}}

                    {{--data +=--}}
                    {{--' <div style="display: none" id="l_'+tot+'" class="child item"+cnt>' +--}}
                    {{--'<div class="content">' +--}}
                    {{--'<div class="card">'+--}}
                        {{--'<div class="card-header">'+--}}
                            {{--'<h4 class="card-title row">'+--}}
                                {{--'<div class="col-12">'+--}}
                                    {{--val['title']+--}}
                                {{--'</div>'+--}}
                            {{--'</h4>'+--}}
                        {{--'</div>'+--}}
                        {{--'<ul class="list-group" style="margin: 0;margin-top: 0;padding: 0;">'+--}}
                            {{--'<li class="list-group-item">'+--}}
                                {{--'<div class="row">'+--}}
                                    {{--'<div class="col-lg-12">'+--}}
                                        {{--'<p class="mb-0 feed-image">'+val['description']+'...</p>'+--}}
                                        {{--'<p class="mb-0"><small class="text-muted"><i>Posted '+val['date']+'</i></small></p>'+--}}
                                    {{--'</div>'+--}}
                                {{--'</div>'+--}}
                            {{--'</li>'+--}}
                            {{--'<li class="list-group-item center">'+--}}
                                {{--'<a type="submit" href="'+val['link']+'" class="btn btn-default" target="_blank" title="See More"> See More</a>'+--}}
                            {{--'</li>'+--}}
                        {{--'</ul>'+--}}
                    {{--'</div></div></div>';--}}
                    {{--tot++;--}}

                {{--});--}}

                {{--$("#feeds").html(data);--}}
            {{--}}--}}
    {{--);--}}

    $.ajax(
        {url: "{{ route('blog.data') }}",
            success: function(result)
            {
                //alert(result);
                var data = "";
                var data1 = "";
                var cnt = 1;
                var tot = 1;
                var stat = "";
                result.forEach(function(val, index) {

                    var url = '{{ url('blog/:id/:title') }}';
                    url = url.replace(':id', encodeURIComponent(val['id']));
                    url = url.replace(':title', encodeURIComponent(val['title']));

                    if (tot==1){
                        stat = "active";
                    }
                    else{
                        stat = "";
                    }

                    data += '<div class="carousel-item '+stat+'">'+
                        '<div class="row">'+
                            '<div class="col-md-12">'+
                                '<div class="card mb-0">'+
                                    '<div class="card-header">'+
                                        '<h4 class="card-title">'+val['title']+'</h4>'+
                                    '</div>'+
                                    '<img class="card-img-top mb-2" src="'+val['image']+'" alt="'+val['title']+'" style="float: left; width:  100%;height: 300px;object-fit: cover;">'+
                                        '<div class="card-body center" >'+
                                            '<a class="btn btn-primary" href="'+url+'">Learn More</a>'+
                                        '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
                    //tot++;

                    data1 +=
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
                });

                //alert(data);
                $("#blog_slider").show();
                $("#blogs").html(data);
                $("#feeds").html(data1);
            }}
    );

    function strip(html)
    {
        var tmp = document.implementation.createHTMLDocument("New").body;
        tmp.innerHTML = html;
        return tmp.textContent || tmp.innerText || "";
    }

    var w = $('#website_id').val();
    // $.ajax(
    //     {url: "{{ url('get_recent_post') }}" + '/' + w,
    //     success: function(result)
    //     {
    //         var data = "";
    //         var cnt = 1;
    //         result.forEach(function(val, index) {
    //             if(cnt++ > 3) return false;

    //             var url = '{{ url('websites/:website_id/posts/:id/edit') }}';
    //             url = url.replace(':website_id', val['website_id']);
    //             url = url.replace(':id', val['id']);

    //             data += '<li class="list-group-item">'+
    //                     '<div class="row">'+
    //                     '<div class="col-lg-10">'+
    //                     '<img style="max-width:150px; margin-right:10px;" class="float-left" src="'+val['image']+'" alt="'+val['title']+'">'+
    //                     '<h4><a href="'+url+'">'+val['title']+'</a></h4>'+
    //                     '<p class=""><small>'+val['content']+'</small></p>'+
    //                     '<p class="mb-0"><small><i>Posted '+val['created_at']+'</i></small></p>'+
    //                     '<p class=""><small></small></p>'+

    //                     '</div>'+
    //                     '<div class="col-lg-2">'+
    //                     '<div class="btn-group pull-right">'+
    //                     '<a href="'+url+'" title="Edit" class="btn btn-sm btn-primary "><i class="fa fa-angle-right"></i></a>'+
    //                     '</div>'+
    //                     '</div>'+
    //                     '</div>'+
    //                     '</li>';
    //         });

    //         var url2 = '{{ url('websites/:id/posts') }}';
    //         url2 = url2.replace(':id', w);
    //         data +='<li class="list-group-item center">' +
    //                 '<a type="submit" href="'+url2+'" class="btn btn-default" title="See More">See More</a>' +
    //             '</li>';

    //         // $("#recent_post").html(data);
    //     }}
    // );

    /* ----------------------------------- */

</script>
@if(isset($user_chart))
@include('fe.layouts._highcharts')
{!! $user_chart->script() !!}
@endif

<script src="{{ asset('/stuff/home_page.js') }}"></script>
<script src="{{ asset('assets/css/bricklayer/dist/bricklayer.js') }}"></script>
<script src="{{ asset('assets/css/bricklayer/demo.js') }}"></script>

@endsection