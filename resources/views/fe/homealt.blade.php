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

@foreach($widgets->child_order as $witem)
    @include($witem->route)
@endforeach

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
</style>


<div class="card-columns" id="feeds">
</div>
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
<div class="card" id="raf">
    <div class="card-header">
        <div class="media">
            <div class="media-body">
                <h4 class="card-title">
                    Refer a Friend
                </h4>
            </div>
            <div class="media-right media-middle">
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
            </div>
        </div>
    </div>
    <div class="card-block">
        Tell a friend to sign up with your referral code, give $10, get $10.
        Your Referral code: <strong>{{ $team->token }}</strong>
        <br />
    </div>
</div>


    <div class="card-columns">
        <button data-append>APPEND</button>
        <button data-prepend>PREPEND</button>
        <button data-append-multiple>APPEND MULTIPLE</button>
    </div>


<section class="bricklayer">
</section>




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

    $.ajax(
        {url: "{{ route('feed.rss') }}",
            success: function(result)
            {
                var data = "";
                var cnt = 1;
                var tot =1;
                result.forEach(function(val, index) {
                    //if(cnt++ > 10) return false;
                    var url = '{{ url('automation/feeds/:id/edit') }}';
                    url = url.replace(':id', cnt);

                    data +=
                    ' <div style="display: none" id="l_'+tot+'" class="child item"+cnt>' +
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
                                        '<p class="mb-0 feed-image">'+val['description']+'...</p>'+
                                        '<p class="mb-0"><small class="text-muted"><i>Posted '+val['date']+'</i></small></p>'+
                                    '</div>'+
                                '</div>'+
                            '</li>'+
                            '<li class="list-group-item center">'+
                                '<a type="submit" href="'+val['link']+'" class="btn btn-default" target="_blank" title="See More"> See More</a>'+
                            '</li>'+
                        '</ul>'+
                    '</div></div></div>';
                    tot++;

                });

                //document.getElementById("total_feed").value = tot;


{{--
                var url2 = '{{ route('content.feeds.index') }}';
                if(cnt>1){
                    data += '<li class="list-group-item center">'+
                            '<a type="submit" href="'+url2+'" class="btn btn-default" title="See More"> See More</a>'+
                    '</li>';
                }
--}}
                $("#feeds").html(data);
            }}
    );



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